<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\Room\EmptyRoomNameException;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Tests\TestCase;

class CreateRoomActionTest extends TestCase
{
    public function testAction()
    {
        $user = User::create(['username' => 'testUsers']);
        $room = Room::create(['name' => 'testRoom']);

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/rooms/' . $room->id . '/' . $user->id);
        $response = $app->handle($request);

        $this->assertEquals($user, $room->users()->find($user->id));

        $expectedBody = new ActionPayload(200, $user);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }
}
