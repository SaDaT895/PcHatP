<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;

class JoinRoomAction extends Action
{
    protected function action(): Response
    {
        if (!isset($_SESSION['activeUser'])) throw new HttpBadRequestException($this->request, 'No user set in session. Create or choose an existing one to send messages');

        $groupId = $this->resolveArg('id');
        $room = Room::find($groupId);

        if (!$room) throw new DomainRecordNotFoundException('No such room. Verify ID parameter.');

        $user = $_SESSION['activeUser'];

        $room->users()->sync($user, false);

        return $this->respondWithData($room->users()->find($user));
    }
}
