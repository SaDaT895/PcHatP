<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Slim\Psr7\Response;

class JoinRoomAction extends Action
{
    protected function action(): Response
    {
        $groupId = $this->resolveArg('id');
        $room = Room::find($groupId);

        if (!$room) throw new DomainRecordNotFoundException('No such room. Verify ID parameter.');

        $data = $this->getFormData();
        if (!isset($data['user'])) throw new MissingFieldsException($this->request, ['user']);

        $user = User::find($data['user']);

        if (!$user) throw new DomainRecordNotFoundException('No such user. Check user attribute.');

        $room->users()->sync($user, false);

        return $this->respondWithData($user);
    }
}
