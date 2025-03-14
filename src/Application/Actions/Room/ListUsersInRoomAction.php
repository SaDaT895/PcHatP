<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\InvalidIdException;
use App\Domain\Room\Room;
use Slim\Psr7\Response;

class ListUsersInRoomAction extends Action
{

    protected function action(): Response
    {
        $groupId = (int) $this->resolveArg('id');
        if (!$groupId) throw new InvalidIdException($this->request);

        $room = Room::find($groupId);

        if (!$room) throw new DomainRecordNotFoundException('No such room');

        $room_users = $room->users;
        if (!$room_users->count()) throw new DomainRecordNotFoundException('No users in room. Send a message to join in.');
        return $this->respondWithData($room_users);
    }
}
