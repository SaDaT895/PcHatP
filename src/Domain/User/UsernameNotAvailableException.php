<?php

declare(strict_types=1);

namespace App\Domain\User;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class UsernameNotAvailableException extends HttpBadRequestException
{
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request, 'Username taken. Try another');
    }
}
