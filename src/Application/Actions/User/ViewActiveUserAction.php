<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;
use App\Domain\User\User;


class ViewActiveUserAction extends Action
{
    protected function action(): Response
    {
        if (!isset($_SESSION['activeUser'])) return $this->respondWithData('No user set in session. Choose or create one to get started');
        return $this->respondWithData(User::find($_SESSION['activeUser']));
    }
}
