<?php

namespace FlyingLuscas\Correios\Services;

use Mockery;
use GuzzleHttp\ClientInterface;
use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;

class FreightTest extends TestCase
{
    /**
     * @var \FlyingLuscas\Correios\Services\Freight
     */
    protected $freight;

    public function setUp()
    {
        parent::setUp();

        $http = Mockery::mock(ClientInterface::class);

        $this->freight = new Freight($http);
    }

    public function testSetOrigin()
    {
        $this->assertInstanceOf(Freight::class, $this->freight->origin('99999-999'));
        $this->assertPayloadHas('sCepOrigem', '99999999');
    }

    public function testSetDestination()
    {
        $this->assertInstanceOf(Freight::class, $this->freight->destination('99999-999'));
        $this->assertPayloadHas('sCepDestino', '99999999');
    }

    public function testSetServices()
    {
        $pac = Service::PAC;
        $sedex = Service::SEDEX;

        $this->freight->services($sedex, $pac);

        $this->assertPayloadHas('nCdServico', "{$sedex},{$pac}");
    }

    public function testPayloadWidth()
    {
        $this->freight->item(1, 10, 10, 10, 1)
            ->item(2.5, 10, 10, 10, 1)
            ->item(2, 10, 10, 10, 1);

        $this->assertPayloadHas('nVlLargura', 2.5);
    }

    public function testPayloadHeight()
    {
        $this->freight->item(10, 1, 10, 10, 1)
            ->item(10, 2.5, 10, 10, 1)
            ->item(10, 2, 10, 10, 1);

        $this->assertPayloadHas('nVlAltura', 5.5);
    }

    public function testPayloadLength()
    {
        $this->freight->item(10, 10, 1, 10, 1)
            ->item(10, 10, 2.5, 10, 1)
            ->item(10, 10, 2, 10, 1);

        $this->assertPayloadHas('nVlComprimento', 2.5);
    }

    public function testPayloadWeight()
    {
        $this->freight->item(10, 10, 10, 1, 1)
            ->item(10, 10, 10, 2.5, 1)
            ->item(10, 10, 10, 2, 1);

        $this->assertPayloadHas('nVlPeso', 5.5);
    }

    public function testPayloadWeightWithVolume()
    {
        $this->freight->item(50, 50, 50, 1, 1)
            ->item(50, 50, 50, 2.5, 1)
            ->item(50, 50, 50, 2, 1);

        $this->assertPayloadHas('nVlPeso', 62.5);
    }

    /**
     * Asserts payload has a given key and value.
     *
     * @param  sring $key
     * @param  mixed $value
     *
     * @return self
     */
    protected function assertPayloadHas($key, $value = null)
    {
        if (is_null($value)) {
            $this->assertArrayHasKey($key, $this->freight->payload());
            return $this;
        }

        $this->assertArraySubset([
            $key => $value,
        ], $this->freight->payload());

        return $this;
    }
}
