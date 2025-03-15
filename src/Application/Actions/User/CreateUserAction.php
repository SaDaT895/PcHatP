<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\User\EmptyUsernameException;
use App\Domain\User\User;
use App\Domain\User\UsernameNotAvailableException;
use Slim\Psr7\Response;

class CreateUserAction extends Action
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        if (!isset($data['username'])) throw new MissingFieldsException($this->request, ['username']);
        $username = $data['username'];

        if (!trim($username)) throw new EmptyUsernameException($this->request);

        if (User::where('username', $username)->first()) throw new UsernameNotAvailableException($this->request);

        $user = new User();
        $user->username = $username;
        $user->save();
        $_SESSION['activeUser'] = $user->id;
        return $this->respondWithData($user, 201);
    }
}
