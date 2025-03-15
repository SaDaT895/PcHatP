<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\InvalidIdException;
use App\Domain\User\User;
use Slim\Psr7\Response;

class EditUserAction extends Action
{

    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = User::find($userId);

        if (!$user) throw new DomainRecordNotFoundException('No such user. Verify ID parameter.');
        $user->update($this->getFormData());
        return $this->respondWithData($user);
    }
}
