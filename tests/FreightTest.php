<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
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
    public function it_can_set_services_using_the_constructor()
    {
        $freight = new Freight([
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
