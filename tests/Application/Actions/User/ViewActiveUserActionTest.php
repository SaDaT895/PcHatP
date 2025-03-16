<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewActiveUserActionTest extends TestCase
{

    public function testActionNoUserInSession()
    {
        $app = $this->getAppInstance();
        $_SESSION['activeUser'] = null;

        $request = $this->createRequest('GET', '/users/active');
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, 'No user set in session. Choose or create one to get started');
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }

    public function testAction()
    {
        $app = $this->getAppInstance();
        $user = new User();
        $user->username = '123';
        $user->save();
        $_SESSION['activeUser'] = $user->id;

        $request = $this->createRequest('GET', '/users/active');
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, $user);
        $actualBody = (string) $response->getBody();
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
    }
}
