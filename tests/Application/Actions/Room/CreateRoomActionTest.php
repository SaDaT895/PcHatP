<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
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
}
