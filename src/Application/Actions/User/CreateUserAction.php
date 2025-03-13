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
        $user = new User();
        $data = $this->request->getParsedBody();
        $user->username = $data['username'];
        $user->save();
        return $this->respondWithData('User created with username: ' . $user->username);
    }
}
