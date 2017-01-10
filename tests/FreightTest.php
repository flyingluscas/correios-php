<?php

namespace FlyingLuscas\Correios;

class FreightTest extends TestCase
{
    /** @test */
    public function can_set_the_services_to_be_used()
    {
        $freight = (new Freight)->setServices(1, 2);

        $this->assertInstanceOf(Freight::class, $freight);
        $this->assertEquals(sprintf('%d,%d', 1, 2), $freight->getServices());
    }

    /** @test */
    public function can_set_zip_codes()
    {
        $freight = (new Freight)->setZipCodes('00000-000', '99999-999');

        $this->assertInstanceOf(Freight::class, $freight);
        $this->assertEquals('00000000', $freight->getOriginZipCode());
        $this->assertEquals('99999999', $freight->getDestinyZipCode());
    }
}
