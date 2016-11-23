<?php

namespace FlyingLuscas\Correios;

use Mockery;
use GuzzleHttp\Psr7\Response;
use FlyingLuscas\Correios\Support\FreightUrlBuilder;

class FreightTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideServicesXMLSamples
     */
    public function it_can_calculate_the_freight($sample, $expected)
    {
        $http = $this->getMockForGuzzleClient(
            new Response(200, [], file_get_contents($sample))
        );

        $freight = new Freight(null, $http);
        $freight->setZipCodes('00000-000', '99999-999');
        $freight->cart->fill($this->items(5));

        $this->assertEquals($expected, $freight->calculate());
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
    public function it_can_set_format($format)
    {
        $freight = new Freight;

        $freight->setFormat($format);

        $this->assertEquals($format, $freight->getFormat());
    }

    /**
     * Correios formats.
     *
     * @return array
     */
    public function formats()
    {
        return [
            [Format::BOX],
            [Format::ROLL],
            [Format::ENVELOPE],
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
