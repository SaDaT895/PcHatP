<?php

declare(strict_types=1);

use App\Application\Actions\Message\SendMessageAction;
use App\Application\Actions\Room\CreateRoomAction;
use App\Application\Actions\Room\JoinRoomAction;
use App\Application\Actions\Room\ListMessagesInRoomAction;
use App\Application\Actions\Room\ListRoomsAction;
use App\Application\Actions\Room\ListUsersInRoomAction;
use App\Application\Actions\User\ChooseUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use \App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\EditUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewActiveUserAction;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Welcome to PcHatP');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->post('', CreateUserAction::class);
        $group->put('/{id}', EditUserAction::class);
        $group->post('/{id}', ChooseUserAction::class);
        $group->get('/active', ViewActiveUserAction::class);
        $group->get('', ListUsersAction::class);
    });

    $app->group('/rooms', function (Group $group) {
        $group->get('', ListRoomsAction::class);
        $group->post('', CreateRoomAction::class);
        $group->post('/{id}/join', JoinRoomAction::class);
        $group->get('/{id}/users', ListUsersInRoomAction::class);
        $group->get('/{id}/messages', ListMessagesInRoomAction::class);
    });

    $app->group('/messages', function (Group $group) {
        $group->post('', SendMessageAction::class);
    });
};
