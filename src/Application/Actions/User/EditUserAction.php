<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Application\Exceptions\MissingFieldsException;
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
        $data = $this->getFormData();

        if (!isset($data['username'])) throw new MissingFieldsException($this->request, ['username']);

        $user->update($data);
        return $this->respondWithData($user);
    }
}
