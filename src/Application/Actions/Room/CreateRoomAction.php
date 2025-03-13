<?php

use App\Application\Actions\Action;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class CreateRoomAction extends Action
{

    protected function action(ServerRequestInterface $request): Response
    {
        return $this->respondWithData('Room created');
    }
}
