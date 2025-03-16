<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Application\Exceptions\MissingFieldsException;
use App\Domain\User\EmptyUsernameException;
use App\Domain\User\User;
use App\Domain\User\UsernameNotAvailableException;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    public function testActionMissingUsername()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/users');
        $this->expectException(MissingFieldsException::class);
        $this->expectExceptionMessage('Missing fields: username');
        $response = $app->handle($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testActionEmptyUsername()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/users');
        $this->expectException(EmptyUsernameException::class);
        $this->expectExceptionMessage('Username shall not be empty');
        $response = $app->handle($request->withParsedBody(['username' => '']));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testActionUsernameAlreadyExists()
    {
        $user = new User();
        $user->username = 'test';
        $user->save();

        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/users');
        $this->expectException(UsernameNotAvailableException::class);
        $this->expectExceptionMessage('Username taken. Try another');
        $response = $app->handle($request->withParsedBody(['username' => 'test']));
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testAction()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('POST', '/users');
        $response = $app->handle($request->withParsedBody(['username' => 'test']));
        $this->assertEquals(201, $response->getStatusCode());

        $user = User::where('username', '=', 'test')->first();

        $expectedBody = new ActionPayload(201, $user);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
        $this->assertEquals($user->id, $_SESSION['activeUser']);
    }
}
