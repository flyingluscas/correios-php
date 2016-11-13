<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Exceptions\InvalidFormatException;

class FreightTest extends TestCase
{
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

        $freight->setServices([
            Service::PAC,
            Service::SEDEX,
        ]);

        $this->assertEquals([
            Service::PAC,
            Service::SEDEX,
        ], $freight->getServices());
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
