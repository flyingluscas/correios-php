<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container\Type;

use FlyingLuscas\Correios\Domains\Correios\Container\Container;
use FlyingLuscas\Correios\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @test
     * @dataProvider generateFreightContainers
     */
    public function test_can_generate_a_container($container, $expected)
    {
        $this->assertInstanceOf($expected, $container);
    }

    public function test_can_generate_a_valid_box_container()
    {
        $box = new Box();
        $this->assertTrue($box->isValid());
    }

    public function test_can_generate_a_valid_envelop_container()
    {
        $envelop = new Envelop();
        $this->assertTrue($envelop->isValid());
    }

    public function test_can_generate_a_valid_roll_container()
    {
        $roll = new Roll();
        $this->assertTrue($roll->isValid());
    }

    public function generateFreightContainers()
    {
        return [
            [new Box(), Container::class],
            [new Envelop(), Container::class],
            [new Roll(), Container::class],
        ];
    }
}
