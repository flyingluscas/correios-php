<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
    /**
     * @var \FlyingLuscas\Correios\Freight
     */
    protected $freight;

    public function setUp()
    {
        parent::setUp();

        $this->freight = Correios::freight();
    }

    public function testSetOrigin()
    {
        $this->assertArraySubset([
            'sCepOrigem' => '99999999',
        ], $this->freight->origin('99999-999')->payload());
    }

    public function testSetDestination()
    {
        $this->assertArraySubset([
            'sCepDestino' => '99999999',
        ], $this->freight->destination('99999-999')->payload());
    }

    public function testSetServices()
    {
        $pac = Service::PAC;
        $sedex = Service::SEDEX;

        $this->assertArraySubset([
            'nCdServico' => "{$sedex},{$pac}",
        ], $this->freight->services($sedex, $pac)->payload());
    }
}
