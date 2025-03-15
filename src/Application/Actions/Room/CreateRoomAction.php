<?php

declare(strict_types=1);

namespace App\Application\Actions\Room;

use App\Application\Actions\Action;
use App\Domain\Room\Room;
use Slim\Psr7\Response;
use App\Application\Exceptions\MissingFieldsException;

class CreateRoomAction extends Action
{

    protected function action(): Response
    {
        $room = new Room();
        $data = $this->getFormData();
        if (!isset($data['name'])) throw new MissingFieldsException($this->request, ['name']);

        $room->name = $data['name'];
        $room->save();
        return $this->respondWithData($room, 201);
    }
}
