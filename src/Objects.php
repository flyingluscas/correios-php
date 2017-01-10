<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Contracts\ObjectsInterface;

class Objects implements ObjectsInterface
{
    /**
     * Array de objetos e suas dimensões.
     *
     * @var array
     */
    protected $items;

    /**
     * Create a new class instance.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Adicionar um novo objeto.
     *
     * @param int|float $width
     * @param int|float $height
     * @param int|float $length
     * @param int|float $weight
     * @param int|float $quantity
     *
     * @return self
     */
    public function add($width, $height, $length, $weight, $quantity)
    {
        $this->items[] = [
            'width' => $width,
            'height' => $height,
            'length' => $length,
            'weight' => $weight,
            'quantity' => $quantity,
        ];

        return $this;
    }

    /**
     * Recupera uma array de todos os objetos e suas dimensões.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Recupera a maior lagura entre os objetos.
     *
     * @return int|float
     */
    public function width()
    {
        return max(array_map(function ($item) {
            return $item['width'];
        }, $this->items));
    }

    /**
     * Recupera a altura total de todos os objetos.
     *
     * @return int|float
     */
    public function height()
    {
        return array_sum(array_map(function ($item) {
            return $item['height'] * $item['quantity'];
        }, $this->items));
    }

    /**
     * Recupera o maior comprimento entre os objetos.
     *
     * @return int|float
     */
    public function length()
    {
        return max(array_map(function ($item) {
            return $item['length'];
        }, $this->items));
    }

    /**
     * Recupera o peso total de todos os objetos.
     *
     * @return int|float
     */
    public function weight()
    {
        return array_sum(array_map(function ($item) {
            return $item['weight'] * $item['quantity'];
        }, $this->items));
    }
}