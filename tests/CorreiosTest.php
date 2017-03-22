<?php

namespace FlyingLuscas\Correios;

class CorreiosTest extends TestCase
{
    public function testFreightMethod()
    {
        $freight = Correios::freight();

        $this->assertInstanceOf(Freight::class, $freight);
    }
}
