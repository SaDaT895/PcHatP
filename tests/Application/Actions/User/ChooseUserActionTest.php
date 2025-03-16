<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Slim\Exception\HttpNotFoundException;

class ChooseUserActionTest extends TestCase
{

    public function testAction()
    {
        $app = $this->getAppInstance();
        $user = new User();
        $user->username = 'test';
        $user->save();

        $request = $this->createRequest('POST', '/users/' . $user->id);
        $response = $app->handle($request);
        $expectedBody = new ActionPayload(200, $user);
        $actualBody = (string) $response->getBody();
        $this->assertEquals($user->id, $_SESSION['activeUser']);
        $this->assertJsonStringEqualsJsonString(json_encode($expectedBody, JSON_PRETTY_PRINT), $actualBody);
        $user->delete();
    }

    public function testActionNoSuchUser()
    {
        $app = $this->getAppInstance();
        $imaginaryId = 789;

        $request = $this->createRequest('POST', '/users/' . $imaginaryId);
        $this->expectException(HttpNotFoundException::class);
        $this->expectExceptionMessage('No such user. Verify ID parameter.');
        $response = $app->handle($request);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals($imaginaryId, $_SESSION['activeUser']);
    }
}
