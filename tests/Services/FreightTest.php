<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\PackageType;
use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;
use GuzzleHttp\Client as HttpClient;

class FreightTest extends TestCase
{
    /**
     * @var \FlyingLuscas\Correios\Services\Freight
     */
    protected $freight;

    public function setUp()
    {
        parent::setUp();

        $http = new HttpClient;

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
        $sedex = Service::SEDEX;

        $this->freight->services($sedex);

        $this->assertPayloadHas('nCdServico', $sedex);
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

    public function testSetCredentials()
    {
        $code = '08082650';
        $password = 'n5f9t8';

        $this->assertInstanceOf(Freight::class, $this->freight->credentials($code, $password));
        $this->assertPayloadHas('nCdEmpresa', $code)
            ->assertPayloadHas('sDsSenha', $password);
    }

    /**
     * @dataProvider packageFormatProvider
     */
    public function testSetPackageFormat($format)
    {
        $this->assertInstanceOf(Freight::class, $this->freight->package($format));
        $this->assertPayloadHas('nCdFormato', $format);
    }

    public function testSetOwnHand()
    {
        $this->assertInstanceOf(Freight::class, $this->freight->useOwnHand(false));
        $this->assertPayloadHas('sCdMaoPropria', 'N');

        $this->freight->useOwnHand(true);
        $this->assertPayloadHas('sCdMaoPropria', 'S');
    }

    public function testSetDeclaredValue()
    {
        $value = 10.38;

        $this->assertInstanceOf(Freight::class, $this->freight->declaredValue($value));
        $this->assertPayloadHas('nVlValorDeclarado', $value);
    }

    /**
     * Provide a list of all of the packages types.
     *
     * @return array
     */
    public function packageFormatProvider()
    {
        return [
            [PackageType::BOX],
            [PackageType::ROLL],
            [PackageType::ENVELOPE],
        ];
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
        ], $this->freight->payload(Service::SEDEX));

        return $this;
    }
}
