<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
    /** @test */
    public function can_set_the_services_to_be_used()
    {
        $freight = new Freight;

        $freight->setServices(1, 2);

        $this->assertEquals(sprintf('%d,%d', 1, 2), $freight->getServices());
    }
}
