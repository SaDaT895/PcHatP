<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Room\Room;
use Slim\Psr7\Response;

class ListRoomsAction extends Action
{
    protected function action(): Response
    {
        $rooms = Room::all();
        if (!$rooms->count()) throw new DomainRecordNotFoundException('No rooms online. Create one to get started');
        return $this->respondWithData($rooms);
    }
}
