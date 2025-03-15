<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Application\Actions\Action;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Message\EmptyMessageException;
use App\Domain\Message\Message;
use App\Domain\Room\Room;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;


class SendMessageAction extends Action
{
    protected function action(): Response
    {
        if (!isset($_SESSION['activeUser'])) throw new HttpBadRequestException($this->request, 'No user set in session. Create or choose an existing one to send messages');

        $data = $this->getFormData();

        $missingFields = array_filter(['room', 'message'], fn($field) => !isset($data[$field]));
        if ($missingFields) throw new MissingFieldsException($this->request,  $missingFields);

        $roomId = $data['room'];
        if (!Room::find($roomId)) throw new DomainRecordNotFoundException('No such room');

        $content = $data['message'];
        if (!$content) throw new EmptyMessageException($this->request);
        $sender = $_SESSION['activeUser'];

        $message = new Message();
        $message->content = $content;
        $message->sender_id = $sender;
        $message->room_id = $roomId;
        $message->save();

        return $this->respondWithData($message, 201);
    }
}
