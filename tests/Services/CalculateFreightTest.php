<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;

class CalculateFreightTest extends TestCase
{
    /**
     * @dataProvider calculateFreightProvider
     */
    public function testCalculateFreight($file, array $expected)
    {
        $http = $this->mockHttpClient($file);
        $freight = new Freight($http);

        $this->assertEquals($expected, $freight->calculate());
    }

    public function calculateFreightProvider()
    {
        return [
            [
                __DIR__.'/../XMlSamples/ErrorServiceResponse.xml',
                [
                    ['name' => 'Sedex', 'code' => Service::SEDEX, 'price' => 16.1, 'deadline' => 1, 'error' => [
                        'code' => -1,
                        'message' => 'Código de serviço inválido',
                    ]]
                ]
            ],
            [
                __DIR__.'/../XMlSamples/SingleServiceResponse.xml',
                [['name' => 'Sedex', 'code' => Service::SEDEX, 'price' => 16.1, 'deadline' => 1, 'error' => []]]
            ],
            [
                __DIR__.'/../XMlSamples/MultipleServicesResponse.xml',
                [
                    ['name' => 'Sedex', 'code' => Service::SEDEX, 'price' => 16.1, 'deadline' => 1, 'error' => []],
                    ['name' => 'PAC', 'code' => Service::PAC, 'price' => 16.1, 'deadline' => 5, 'error' => []],
                ]
            ],
        ];
    }
}
