<?php

declare(strict_types=1);

namespace App\Domain\Room;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class EmptyRoomNameException extends HttpBadRequestException
{
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request, 'Room name shall not be empty.');
    }
}
