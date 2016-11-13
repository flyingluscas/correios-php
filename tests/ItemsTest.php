<?php

namespace FlyingLuscas\Correios;

class ItemsTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_add_multiple_items()
    {
        $items = $this->items(5);

        $collection = new Items;
        $collection->fill($items);

        $this->assertEquals($items, $collection->toArray());
    }

    /**
     * @test
     */
    public function it_can_add_a_single_item()
    {
        $item = $this->items(1)[0];
        $item['dummy'] = 10;

        $collection = new Items;

        $collection->push($item);

        $this->assertEquals([
            [
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
            ]
        ], $collection->toArray());
    }

    /**
     * Make stub items.
     *
     * @param  int $amount
     *
     * @return array
     */
    private function items($amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            $results[] = [
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
            ];
        }

        return $results;
    }
}
