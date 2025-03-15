<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Message\Message;
use App\Domain\Room\Room;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;


class SendMessageAction extends Action
{
    protected function action(): Response
    {
        $data = $this->getFormData();
        $roomId = $data['room'];
        $content = $data['content'];
        $sender = $_SESSION['activeUser'];

        if (!Room::find($roomId)) throw new DomainRecordNotFoundException('No such room, verify room attribute in body');
        if (!$content) throw new HttpBadRequestException($this->request, 'Missing or empty content');
        if (!$sender) throw new HttpBadRequestException($this->request, 'No user set in session. Create or choose an existing one to send messages');


        $message = new Message();
        $message->content = $content;
        $message->sender_id = $sender;
        $message->room_id = $roomId;
        $message->save();

        return $this->respondWithData($message, 201);
    }
}
