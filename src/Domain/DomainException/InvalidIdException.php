<?php

declare(strict_types=1);

namespace App\Domain\DomainException;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;



class InvalidIdException extends HttpBadRequestException
{

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request, 'Invalid ID, Must be an integer');
    }
}
