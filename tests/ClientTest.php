<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Services\Freight;

class ClientTest extends TestCase
{
    public function testFreightService()
    {
        $correios = new Client;

        $this->assertInstanceOf(Freight::class, $correios->freight());
    }
}
