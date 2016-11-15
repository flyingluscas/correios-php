<?php

namespace FlyingLuscas\Correios;

use PHPUnit_Framework_TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Make stub items.
     *
     * @param  int   $amount
     * @param  array $data
     *
     * @return array
     */
    protected function items($amount, array $data = [])
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
