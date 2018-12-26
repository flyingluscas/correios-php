<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;
use GuzzleHttp\Client as HttpClient;

class CalculateFreightTest extends TestCase
{
    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    public function setUp()
    {
        parent::setUp();

        $this->http = new HttpClient;
    }

    public function testInvalidServiceError()
    {
        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services('99999')
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => null,
                'code' => '99999',
                'price' => 0,
                'deadline' => 0,
                'error' => [
                    'code' => '001',
                    'message' => 'Codigo de servico invalido.',
                ],
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }

    public function testWithSingleService()
    {
        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services(Service::SEDEX)
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => 'Sedex',
                'code' => Service::SEDEX,
                'price' => 49.7,
                'deadline' => 3,
                'error' => [],
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }

    public function testWithMultipleServices()
    {
        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services(Service::SEDEX, Service::PAC)
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => 'Sedex',
                'code' => Service::SEDEX,
                'price' => 49.7,
                'deadline' => 3,
                'error' => [],
            ],
            [
                'name' => 'PAC',
                'code' => Service::PAC,
                'price' => 25.1,
                'deadline' => 9,
                'error' => [],
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }
}
