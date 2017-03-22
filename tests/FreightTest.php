<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
    public function testSetServices()
    {
        $pac = Service::PAC;
        $sedex = Service::SEDEX;
        $freight = Correios::freight()->services($sedex, $pac);

        $this->assertArraySubset([
            'nCdServico' => "{$sedex},{$pac}",
        ], $freight->payload());
    }
}
