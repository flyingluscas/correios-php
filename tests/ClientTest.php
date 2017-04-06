<?php

namespace FlyingLuscas\Correios;

use Mockery;
use FlyingLuscas\Correios\Services\Freight;

class ClientTest extends TestCase
{
    /**
     * @var \FlyingLuscas\Correios\Client
     */
    protected $correios;

    public function setUp()
    {
        parent::setUp();

        $this->correios = new Client(
            Mockery::mock(Freight::class)
        );
    }

    public function testFreightService()
    {
        $this->assertInstanceOf(Freight::class, $this->correios->freight());
    }
}
