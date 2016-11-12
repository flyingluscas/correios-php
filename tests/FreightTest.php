<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
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
