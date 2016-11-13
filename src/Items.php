<?php

namespace FlyingLuscas\Correios;

use Illuminate\Support\Collection;

class Items
{
    /**
     * Collection of items.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * Default item values.
     *
     * @var array
     */
    protected $default = [
        'width' => 0,
        'height' => 0,
        'length' => 0,
        'weight' => 0,
    ];

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->items = new Collection;
    }

    /**
     * Fill items collection.
     *
     * @param  array  $items
     *
     * @return self
     */
    public function fill(array $items)
    {
        foreach ($items as $item) {
            $this->push($item);
        }

        return $this;
    }

    /**
     * Push a single item to the end of the collection.
     *
     * @param  array  $item
     *
     * @return self
     */
    public function push(array $item)
    {
        $item = array_filter($item, function ($key) {
            return in_array($key, array_keys($this->default));
        }, ARRAY_FILTER_USE_KEY);

        $this->items->push(array_merge($this->default, $item));

        return $this;
    }

    /**
     * Get all items in the collection as an array.
     *
     * @return array
     */
    public function all()
    {
        return $this->items->all();
    }
}
