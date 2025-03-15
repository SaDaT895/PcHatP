<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;


class ViewActiveUserAction extends Action
{
    protected function action(): Response
    {
        if (!isset($_SESSION['activeUser'])) return $this->respondWithData('No user set in session. Choose or create one to get started');
        return $this->respondWithData('Active user:' . $_SESSION['activeUser']);
    }
}
