<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Domain\Room\Room;
use Slim\Psr7\Response;

class CreateRoomAction extends Action
{

    protected function action(): Response
    {
        $room = new Room();
        $data = $this->getFormData();
        $room->name = $data['name'];
        $room->save();
        return $this->respondWithData('Room created ' . $room->name, 201);
    }
}
