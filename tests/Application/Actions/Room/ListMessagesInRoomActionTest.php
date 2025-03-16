<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Room;

use App\Application\Actions\ActionPayload;
use App\Domain\Message\Message;
use App\Domain\Room\Room;
use App\Domain\User\User;
use Tests\TestCase;

class ListMessagesInRoomActionTest extends TestCase
{

    public function testAction()
    {
        $room = Room::create(['name' => 'testRoom']);

        $app = $this->getAppInstance();
        Message::insert(['content' => 'Message 1'], ['content' => 'Message 2']);

        $room->messages()->savemany(Message::all());

        $request = $this->createRequest('GET', '/rooms/' . $room->id . '/messages');
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, $room->messages);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }
}
