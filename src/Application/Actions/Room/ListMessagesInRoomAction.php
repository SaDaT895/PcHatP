<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\InvalidIdException;
use App\Domain\Room\Room;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;

class ListMessagesInRoomAction extends Action
{
    protected function action(): Response
    {
        $groupId = (int) $this->resolveArg('id');
        if (!$groupId) throw new InvalidIdException($this->request);

        $room = Room::find($groupId);

        if (!$room) throw new DomainRecordNotFoundException('No such room');

        $room_messages = $room->messages;
        if (!$room_messages->count()) throw new DomainRecordNotFoundException('No messages in room');
        return $this->respondWithData($room_messages);
    }
}
