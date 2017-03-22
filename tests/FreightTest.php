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
            'nCdServico' => $sedex.','.$pac,
        ], $this->freight->services($sedex, $pac)->payload());
    }

    public function testPushItem()
    {
        $this->assertEquals([
            ['width' => 1, 'height' => 1, 'length' => 1, 'weight' => 1, 'quantity' => 1],
            ['width' => 1, 'height' => 1, 'length' => 1, 'weight' => 1, 'quantity' => 2],
        ], $this->freight->item(1, 1, 1, 1, 1)->item(1, 1, 1, 1, 2)->items);
    }

    public function testItemsDimenionsCalculations()
    {
        $this->freight->item(1, 1, 1, 1, 1)->item(2, 1, 2, 1, 2);

        $this->assertArraySubset([
            'nVlAltura' => 3,
            'nVlLargura' => 2,
            'nVlComprimento' => 2,
        ], $this->freight->payload());
    }
}
