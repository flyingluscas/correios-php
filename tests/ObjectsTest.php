<?php

namespace FlyingLuscas\Correios;

class ObjectsTest extends TestCase
{
    /** @test */
    public function can_add_items()
    {
        $objects = (new Objects)->add(1, 1, 1, 1, 1);

        $this->assertInstanceOf(Objects::class, $objects);
        $this->assertEquals([
            [
                'width' => 1,
                'height' => 1,
                'length' => 1,
                'weight' => 1,
                'quantity' => 1,
            ]
        ], $objects->all());
    }

    /** @test */
    public function can_get_the_biggest_width_of_all_objects()
    {
        $objects = new Objects([
            ['width' => 1],
            ['width' => 2],
            ['width' => 3],
        ]);

        $this->assertEquals(3, $objects->width());
    }

    /** @test */
    public function can_get_the_total_height_of_the_objects()
    {
        $objects = new Objects([
            ['height' => 1, 'quantity' => 1],
            ['height' => 2, 'quantity' => 1],
            ['height' => 3, 'quantity' => 2],
        ]);

        $this->assertEquals(9, $objects->height());
    }

    /** @test */
    public function can_get_the_biggest_length_of_all_objects()
    {
        $objects = new Objects([
            ['length' => 1],
            ['length' => 2],
            ['length' => 3],
        ]);

        $this->assertEquals(3, $objects->length());
    }

    /** @test */
    public function can_get_the_total_weight_of_the_objects()
    {
        $objects = new Objects([
            ['weight' => 1, 'quantity' => 1],
            ['weight' => 2, 'quantity' => 1],
            ['weight' => 3, 'quantity' => 2],
        ]);

        $this->assertEquals(9, $objects->weight());
    }

    /** @test */
    public function can_get_the_total_volume_of_the_objects()
    {
        $objects = new Objects([
            ['width' => 1, 'height' => 1, 'length' => 1, 'weight' => 1, 'quantity' => 1],
            ['width' => 2, 'height' => 2, 'length' => 2, 'weight' => 2, 'quantity' => 1],
            ['width' => 3, 'height' => 3, 'length' => 3, 'weight' => 3, 'quantity' => 2],
        ]);

        $this->assertEquals(0.0135, $objects->volume());
    }
}
