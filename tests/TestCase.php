<?php

declare(strict_types=1);

namespace Tests;

use Tests\TestSqLiteAdapter;
use DI\ContainerBuilder;
use Exception;
use Phinx\Console\PhinxApplication;
use Phinx\Db\Adapter\AdapterFactory;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;
use Symfony\Component\Console\Input\StringInput;
use \Illuminate\Database\Capsule\Manager;

class TestCase extends PHPUnit_TestCase
{
    use ProphecyTrait;


    /**
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(): App
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        $capsule = new Manager();
        $capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  => __DIR__ . '/../db/db.testing.sqlite',
            // 'database' => ':memory:'
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // add Illuminate 
        $container['db'] = function ($container) use ($capsule) {
            return $capsule;
        };

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = require __DIR__ . '/../config/middleware.php';
        $middleware($app);

        // Register routes
        $routes = require __DIR__ . '/../config/routes.php';
        $routes($app);

        //testing with  in-memory: SQLite is troublesome, using file for now
        // AdapterFactory::instance()->registerAdapter('testsqlite', TestSqLiteAdapter::class);


        return $app;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $headers
     * @param array  $cookies
     * @param array  $serverParams
     * @return Request
     */
    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }

    public function setUp(): void
    {
        $phinx = new PhinxApplication();
        $phinx->setAutoExit(false);
        $phinx->run(new StringInput('migrate -c config/phinx.php -e testing'));
    }

    public function tearDown(): void
    {
        $phinx = new PhinxApplication();
        $phinx->setAutoExit(false);
        $phinx->run(new StringInput('rollback -c config/phinx.php -e testing -t 0'));
        $_SESSION = array();
    }
}
