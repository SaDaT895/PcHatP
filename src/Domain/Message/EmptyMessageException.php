<?php

declare(strict_types=1);

namespace App\Domain\Message;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class EmptyMessageException extends HttpBadRequestException
{
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request, 'Empty message content');
    }
}
