<?php

namespace FlyingLuscas\Correios;

class ItemsTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_max_length()
    {
        $items = [
            $this->items(1, ['length' => 5]),
            $this->items(1, ['length' => 10]),
        ];

        $collection = new Items;

        $this->assertEquals(10, $collection->fill($items)->getMaxLength());
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

        $collection = new Items;

        $this->assertEquals(10, $collection->fill($items)->getMaxWidth());
    }

    /**
     * @test
     */
    public function it_can_add_multiple_items()
    {
        $items = $this->items(5);

        $collection = new Items;
        $collection->fill($items);

        $this->assertEquals($items, $collection->all());
    }

    /**
     * @test
     */
    public function it_can_add_a_single_item()
    {
        $item = $this->items(1);
        $item['dummy'] = 10;

        $collection = new Items;

        $collection->push($item);

        $this->assertEquals([
            [
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
                'quantity' => 1,
            ]
        ], $collection->all());
    }

    /**
     * Make stub items.
     *
     * @param  int   $amount
     * @param  array $data
     *
     * @return array
     */
    private function items($amount, array $data = [])
    {
        for ($i = 0; $i < $amount; $i++) {
            $results[] = array_merge([
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
                'quantity' => 1,
            ], $data);
        }

        return ($amount > 1) ? $results : $results[0];
    }
}
