<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\User;
use App\Domain\User\UsernameNotAvailableException;
use Slim\Psr7\Response;

class CreateUserAction extends Action
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        if (User::where('username', $data['username'])->first()) throw new UsernameNotAvailableException($this->request);
        $user = new User();
        $user->username = $data['username'];
        $user->save();
        return $this->respondWithData('User created with username: ' . $user->username, 201);
    }
}
