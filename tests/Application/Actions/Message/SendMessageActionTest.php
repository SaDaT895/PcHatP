<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Message;

use App\Application\Actions\ActionPayload;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\Message\Message;
use App\Domain\Room\Room;
use Slim\Exception\HttpBadRequestException;
use Tests\TestCase;

class SendMessageActionTest extends TestCase
{
    public function testAction()
    {
        $_SESSION['activeUser'] = 1;
        $room = Room::create(['name' => 'testRoom']);

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/messages');
        $response = $app->handle($request->withParsedBody(['message' => 'New mesasge', 'room' => $room->id]));

        $message = Message::all()->first();

        $expectedBody = new ActionPayload(201, $message);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }

    public function testActionMissingRoomName()
    {
        $_SESSION['activeUser'] = 1;

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/messages');
        $this->expectException(MissingFieldsException::class);
        $this->expectExceptionMessage('Missing fields: room');
        $app->handle($request->withParsedBody(['message' => 'New mesasge']));
    }


    public function testActionMissingMessage()
    {
        $_SESSION['activeUser'] = 1;

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/messages');
        $this->expectException(MissingFieldsException::class);
        $this->expectExceptionMessage('Missing fields: message');
        $app->handle($request->withParsedBody(['room' => 1]));
    }

    public function testActionNoUserInSession()
    {
        $room = Room::create(['name' => 'testRoom']);

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/messages');
        $this->expectException(HttpBadRequestException::class);
        $this->expectExceptionMessage('No user set in session. Create or choose an existing one to send messages');
        $app->handle($request->withParsedBody(['message' => 'New mesasge', 'room' => $room->id]));
    }
}
