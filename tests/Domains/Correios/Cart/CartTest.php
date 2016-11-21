<?php

namespace FlyingLuscas\Correios\Domains\Correios\Cart;

use FlyingLuscas\Correios\TestCase;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_volume()
    {
        $items = $this->items(5, [
            'width' => 5,
            'height' => 10,
            'length' => 15,
        ]);

        $cart = new Cart;

        $this->assertEquals(0.625, $cart->fill($items)->getTotalVolume());
    }

    /**
     * @test
     */
    public function it_can_get_total_weight()
    {
        $items = [
            $this->items(1, ['weight' => 5]),
            $this->items(1, ['weight' => 5]),
            $this->items(1, [
                'weight' => 5,
                'quantity' => 2,
            ]),
        ];

        $cart = new Cart;

        $this->assertEquals(20, $cart->fill($items)->getTotalWeight());
    }

    /**
     * @test
     */
    public function it_can_get_max_length()
    {
        $items = [
            $this->items(1, ['length' => 5]),
            $this->items(1, ['length' => 10]),
        ];

        $cart = new Cart;

        $this->assertEquals(10, $cart->fill($items)->getMaxLength());
    }

    /**
     * @test
     */
    public function it_can_get_total_height()
    {
        $items = [
            $this->items(1, ['height' => 5]),
            $this->items(1, ['height' => 5]),
            $this->items(1, [
                'height' => 5,
                'quantity' => 2,
            ]),
        ];

        $cart = new Cart;

        $this->assertEquals(20, $cart->fill($items)->getTotalHeight());
    }

    /**
     * @test
     */
    public function it_can_get_max_width()
    {
        $items = [
            $this->items(1, ['width' => 5]),
            $this->items(1, ['width' => 10]),
        ];

        $cart = new Cart;

        $this->assertEquals(10, $cart->fill($items)->getMaxWidth());
    }

    /**
     * @test
     */
    public function it_can_add_multiple_items()
    {
        $items = $this->items(5);

        $cart = new Cart;
        $cart->fill($items);

        $this->assertEquals($items, $cart->all());
    }

    /**
     * @test
     */
    public function it_can_add_a_single_item()
    {
        $item = $this->items(1);
        $item['dummy'] = 10;

        $cart = new Cart;

        $cart->push($item);

        $this->assertEquals([
            [
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
                'quantity' => 1,
            ]
        ], $cart->all());
    }
}
