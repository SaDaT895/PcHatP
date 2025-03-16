<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\User;
use Tests\TestCase;
use Slim\Exception\HttpNotFoundException;

class ListUsersActionTest extends TestCase
{

    public function testAction()
    {
        $app = $this->getAppInstance();
        User::create(
            ['username' => 'User 1'],
            ['username' => 'User 2']
        );

        $request = $this->createRequest('GET', '/users');
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, User::all());
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }

    public function testActionNoUsers()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/users');
        $this->expectException(HttpNotFoundException::class);
        $this->expectExceptionMessage('No users online. Create one to get started');
        $app->handle($request);
    }
}
