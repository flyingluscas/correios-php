<?php

namespace FlyingLuscas\Correios\Domains\Correios\Freight;

use FlyingLuscas\Correios\Domains\Correios\Container\Type\Box;
use FlyingLuscas\Correios\Domains\Correios\Container\Type\Envelop;
use FlyingLuscas\Correios\Domains\Correios\Container\Type\Roll;
use FlyingLuscas\Correios\TestCase;
use Mockery;
use GuzzleHttp\Psr7\Response;
use FlyingLuscas\Correios\Support\FreightUrlBuilder;

class FreightTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_calculate_the_freight_for_multiple_services()
    {
        $http = $this->getMockForGuzzleClient(
            new Response(200, [], file_get_contents(__DIR__ . '/../../../Samples/ManyServices.xml'))
        );

        $urlBuilder = Mockery::mock(FreightUrlBuilder::class, function ($mock) {
            $mock->shouldReceive('makeUrl')->andReturn('some_dummy_url');
        });

        $freight = new Freight(null, $http);
        $freight->setServices(Service::SEDEX, Service::PAC);
        $freight->setZipCodes('00000-000', '99999-999');
        $freight->cart->fill($this->items(5));

        $results = [
            [
                'service' => Service::SEDEX,
                'value' => 16.10,
                'deadline' => 1,
                'own_hand_value' => 0.0,
                'notice_receipt_value' => 0.0,
                'declared_value' => 0.0,
                'home_delivery' => true,
                'saturday_delivery' => false,
                'error' => [
                    'code' => 0,
                    'message' => null,
                ],
            ],
            [
                'service' => Service::PAC,
                'value' => 16.10,
                'deadline' => 5,
                'own_hand_value' => 0.0,
                'notice_receipt_value' => 0.0,
                'declared_value' => 0.0,
                'home_delivery' => true,
                'saturday_delivery' => false,
                'error' => [
                    'code' => 0,
                    'message' => null,
                ],
            ]
        ];

        $this->assertEquals($results, $freight->calculate($urlBuilder));
    }

    /**
     * @test
     */
    public function it_can_calculate_the_freight_for_a_single_service()
    {
        $http = $this->getMockForGuzzleClient(
            new Response(200, [], file_get_contents(__DIR__ . '/../../../Samples/SingleService.xml'))
        );

        $urlBuilder = Mockery::mock(FreightUrlBuilder::class, function ($mock) {
            $mock->shouldReceive('makeUrl')->andReturn('some_dummy_url');
        });

        $freight = new Freight(null, $http);
        $freight->setServices(Service::SEDEX);
        $freight->setZipCodes('00000-000', '99999-999');
        $freight->cart->fill($this->items(5));

        $results = [
            [
                'service' => Service::SEDEX,
                'value' => 16.10,
                'deadline' => 1,
                'own_hand_value' => 0.0,
                'notice_receipt_value' => 0.0,
                'declared_value' => 0.0,
                'home_delivery' => true,
                'saturday_delivery' => false,
                'error' => [
                    'code' => 0,
                    'message' => null,
                ],
            ]
        ];

        $this->assertEquals($results, $freight->calculate($urlBuilder));
    }

    /**
     * @test
     */
    public function it_can_set_notice_of_receipt()
    {
        $freight = new Freight;

        $this->assertEquals('S', $freight->setNoticeOfReceipt(true)->getNoticeOfReceipt());
        $this->assertEquals('N', $freight->setNoticeOfReceipt(false)->getNoticeOfReceipt());
    }

    /**
     * @test
     */
    public function it_can_set_declared_value()
    {
        $freight = new Freight;

        $freight->setDeclaredValue(23.75);

        $this->assertEquals(23.75, $freight->getDeclaredValue());
    }

    /**
     * @test
     */
    public function it_can_set_own_hand()
    {
        $freight = new Freight;

        $this->assertEquals('S', $freight->setOwnHand(true)->getOwnHand());
        $this->assertEquals('N', $freight->setOwnHand(false)->getOwnHand());
    }

    /**
     * @test
     * @dataProvider formats
     */
    public function it_can_set_format($format, $expected)
    {
        $freight = new Freight;

        $freight->setFormat($format);

        $this->assertInstanceOf($expected, $freight->getFormat());
        $this->assertEquals($expected, get_class($freight->getFormat()));
    }

    /**
     * Correios formats.
     *
     * @return array
     */
    public function formats()
    {
        return [
            [new Box(), Box::class],
            [new Roll(), Roll::class],
            [new Envelop(), Envelop::class],
        ];
    }

    /**
     * @test
     */
    public function it_can_set_zip_codes()
    {
        $freight = new Freight;
        $freight->setZipCodes('00000-000', '99999-999');

        $this->assertEquals('00000000', $freight->getOriginZipCode());
        $this->assertEquals('99999999', $freight->getDestinyZipCode());
    }

    /**
     * @test
     */
    public function it_can_set_credentials()
    {
        $companyCode = 'SomeCompanyCode';
        $companyPassword = 'SomeCompanyPassword';

        $freight = new Freight;
        $freight->setCredentials($companyCode, $companyPassword);

        $this->assertEquals($companyCode, $freight->getCompanyCode());
        $this->assertEquals($companyPassword, $freight->getCompanyPassword());
    }

    /**
     * @test
     */
    public function it_can_set_multiple_services_using_array()
    {
        $freight = new Freight;
        $services = [
            Service::PAC,
            Service::SEDEX,
        ];

        $freight->setServices($services);

        $this->assertEquals($services, $freight->getServices());
    }

    /**
     * @test
     */
    public function it_can_set_multiple_services()
    {
        $freight = new Freight;

        $freight->setServices(Service::PAC, Service::SEDEX);

        $this->assertEquals([
            Service::PAC,
            Service::SEDEX,
        ], $freight->getServices());
    }

    /**
     * @test
     */
    public function it_can_set_one_single_service()
    {
        $freight = new Freight;

        $freight->setServices(Service::SEDEX);

        $this->assertEquals([
            Service::SEDEX,
        ], $freight->getServices());
    }
}
