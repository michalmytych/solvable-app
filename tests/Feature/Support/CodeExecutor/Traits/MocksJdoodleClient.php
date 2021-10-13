<?php

namespace Tests\Feature\Support\CodeExecutor\Traits;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use App\Support\ExternalCompiler\Client as JdoodleClient;

trait MocksJdoodleClient
{
    protected function mockJdoodleClient(array ...$responses)
    {
        app()->singleton(JdoodleClient::class, function ($app) use ($responses) {
            $mock = new MockHandler(...$responses);

            $handlerStack = HandlerStack::create($mock);

            return new JdoodleClient(['handler' => $handlerStack]);
        });
    }
}
