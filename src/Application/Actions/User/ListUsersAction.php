<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use Slim\Psr7\Response;

class ListUsersAction extends Action
{
    protected function action(): Response
    {
        $users = User::all();
        if (!$users->count()) throw new DomainRecordNotFoundException('No users online. Create one to get started');
        return $this->respondWithData($users);
    }
}
