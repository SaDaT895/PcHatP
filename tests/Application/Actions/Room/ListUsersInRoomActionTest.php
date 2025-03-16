<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Tests\TestCase;

class ListUsersInRoomActionTest extends TestCase
{

    public function testAction()
    {
        $room = Room::create(['name' => 'testRoom']);

        $app = $this->getAppInstance();
        User::insert(
            ['username' => 'User 1'],
            ['username' => 'User 2']
        );

        $room->users()->saveMany(User::all());

        $request = $this->createRequest('GET', '/rooms/' . $room->id . '/users');
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, $room->users);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }
}
