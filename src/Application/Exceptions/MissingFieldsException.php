<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;



class MissingFieldsException extends HttpBadRequestException
{
    public function __construct(ServerRequestInterface $request, array $fields)
    {
        parent::__construct($request, 'Missing fields: ' . implode(',',  $fields));
    }
}
