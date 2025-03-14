<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use Slim\Psr7\Response;

class ChooseUserAction extends Action
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = User::find($userId);

        if (!$user) throw new DomainRecordNotFoundException('No such user. Verify ID parameter.');

        $_SESSION['activeUser'] = $user->id;

        return $this->respondWithData('Active User: ' . $user->id . ' ' . $user->username);
    }
}
