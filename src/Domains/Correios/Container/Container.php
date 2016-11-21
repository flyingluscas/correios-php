<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container;
use FlyingLuscas\Correios\Exceptions\InvalidContainerDimensionsException;

/**
 * Interface Container
 * @package Domains\Correios\Container
 */
interface Container
{
    /**
     * @param array $dimensions
     * @return void
     * @throws InvalidContainerDimensionsException
     */
    public function validateDimensions(array $dimensions);
}