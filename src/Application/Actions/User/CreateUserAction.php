<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\User;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class CreateUserAction extends Action
{
    protected function action(): Response
    {
        // $user = new User();
        $user = ($this->request->getParsedBody());
        return $this->respondWithData($user);
    }
}
