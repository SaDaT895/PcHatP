<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Tests\TestCase;

class JoinRoomActionTest extends TestCase
{
    public function testAction()
    {
        $user = User::create(['username' => 'testUser']);
        $room = Room::create(['name' => 'testRoom']);
        $_SESSION['activeUser'] = $user->id;

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/rooms/' . $room->id . '/join');
        $response = $app->handle($request);

        $this->assertTrue($room->users()->find($user->id)->exists());

        $expectedBody = new ActionPayload(200, $room->users()->find($user->id));
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }
}
