<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function setMockGuzzleClient($alias, $statusCode = 200)
    {
        $response = file_get_contents(sprintf(
            '%s/tests/Mocks/%s.json',
            dirname(__DIR__),
            $alias
        ));
        $mock = new MockHandler([
            new Response(
                $statusCode,
                ['Content-Length' => strlen($response)],
                $response
            )
        ]);

        $this->app->singleton(Client::class, function () use ($mock) {
            $handler = HandlerStack::create($mock);
            return new Client(['handler' => $handler]);
        });
    }
}
