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
    /**
     * @dataProvider calculateFreightProvider
     */
    public function testCalculateFreight($XMLSampleFile, array $expected)
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents($XMLSampleFile))
        ]);

        $http = new Client([
            'handler' => HandlerStack::create($mock),
        ]);

        $freight = new Freight($http);

        $this->assertEquals($expected, $freight->calculate());
    }

    public function calculateFreightProvider()
    {
        return [
            [
                realpath(__DIR__.'/../XMlSamples/SingleServiceResponse.xml'),
                [['code' => Service::SEDEX, 'price' => 16.1, 'deadline' => 1, 'error' => []]]
            ],
            [
                realpath(__DIR__.'/../XMlSamples/MultipleServicesResponse.xml'),
                [
                    ['code' => Service::SEDEX, 'price' => 16.1, 'deadline' => 1, 'error' => []],
                    ['code' => Service::PAC, 'price' => 16.1, 'deadline' => 5, 'error' => []],
                ]
            ],
        ];
    }
}
