<?php

namespace Tests\Feature\Support\CodeExecutor\Traits;

use Mockery;
use GuzzleHttp\Psr7\Response;
use App\Support\ExternalCompiler\Client as JdoodleClient;

/**
 * @method app() ->Application
 */
trait MocksJdoodleClient
{
    protected function executeWithJdoodleClientMock(?Response $executionResponse)
    {
        $mock = Mockery::mock(JdoodleClient::class)
            ->shouldReceive('postCodeToExecute')
            ->andReturn(new Response(
                200,
                ['Content-Type' => 'application/json'],
                json_encode([
                    'output' => '4',
                    'statusCode' => 200,
                    'memory' => 100,
                    'cpuTime' => 10
                ])
            ))
            ->getMock();

        $this->app()->instance(JdoodleClient::class, $mock);
    }
}
