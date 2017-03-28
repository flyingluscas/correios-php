<?php

namespace FlyingLuscas\Correios;

use Mockery;
use FlyingLuscas\Correios\Contracts\CalculableFreightDimensions;

class FreightTest extends TestCase
{
    /**
     * @var \FlyingLuscas\Correios\Freight
     */
    protected $freight;

    public function setUp()
    {
        parent::setUp();

        $mock = Mockery::mock(CalculableFreightDimensions::class);

        $this->freight = new Freight($mock);
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
            'nCdServico' => $sedex.','.$pac,
        ], $this->freight->services($sedex, $pac)->payload());
    }
}
