<?php

namespace FlyingLuscas\Correios\Services;

use Mockery;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;
use GuzzleHttp\Handler\MockHandler;

class CalculateFreightTest extends TestCase
{
    public function testCalculateFreight()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(realpath(__DIR__.'/../XMlSamples/SingleServiceRequest.xml')))
        ]);

        $http = new Client([
            'handler' => HandlerStack::create($mock),
        ]);

        $freight = new Freight($http);

        $freight->origin('01001-000')
            ->destination('87047-230')
            ->services(Service::SEDEX)
            ->item(16, 16, 16, .3, 1)
            ->item(16, 16, 16, .3, 3);

        $this->assertArraySubset([
            'code' => Service::SEDEX,
            'price' => 16.1,
            'deadline' => 1,
            'error' => [],
        ], $freight->calculate());
    }
}
