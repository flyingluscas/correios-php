<?php

namespace FlyingLuscas\Correios\Contracts;

interface CartInterface
{
    /**
     * Get the total volume of all items in the cart.
     *
     * @return int|float
     */
    public function getTotalVolume();

    /**
     * Get the total weight of all items in the cart.
     *
     * @return int|float
     */
    public function getTotalWeight();

    /**
     * Get the most bigger length in the cart.
     *
     * @return int|float
     */
    public function getMaxLength();

    /**
     * Get the total height of all items in the cart.
     *
     * @return int|float
     */
    public function getTotalHeight();

    /**
     * Get the most bigger width in the cart
     *
     * @return int|float
     */
    public function getMaxWidth();
}
