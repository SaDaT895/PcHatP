<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\Room\EmptyRoomNameException;
use App\Domain\Room\Room;
use Tests\TestCase;

class CreateRoomActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/rooms');
        $response = $app->handle($request->withParsedBody(['name' => 'test']));

        $room = Room::where('name', '=', 'test')->first();

        $expectedBody = new ActionPayload(201, $room);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }

    public function testActionMissingRoomName()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/rooms');
        $this->expectException(MissingFieldsException::class);
        $this->expectExceptionMessage('Missing fields: name');
        $app->handle($request);
    }

    public function testActionEmptyUsername()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/rooms');
        $this->expectException(EmptyRoomNameException::class);
        $this->expectExceptionMessage('Room name shall not be empty');
        $response = $app->handle($request->withParsedBody(['name' => '   ']));
        $this->assertEquals(400, $response->getStatusCode());
    }
}
