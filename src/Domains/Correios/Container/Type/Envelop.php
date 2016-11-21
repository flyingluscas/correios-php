<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container\Type;

use FlyingLuscas\Correios\Domains\Correios\Container\AbstractContainer;
use FlyingLuscas\Correios\Exceptions\InvalidContainerDimensionsException;
use FlyingLuscas\Correios\Exceptions\MissingContainerDimensionException;

/**
 * Class Envelop
 * @package FlyingLuscas\Correios\Domains\Correios\Container\Type
 */
class Envelop extends AbstractContainer
{
    protected $minDimensions = [
        'length'    => 16,
        'width'     => 11,
    ];

    protected $maxDimensions = [
        'length'    => 60,
        'width'     => 60,
    ];

    const BASE = ['length' => 16.2, 'width' => 11.4];

    const OFFICE_PRE_PAID = ['length' => 16.2, 'width' => 11.4];

    const PLASTIC_MID = ['length' => 35.3, 'width' => 25];

    const PLASTIC_LARGE = ['length' => 40, 'width' => 28];

    const BUBBLE_PLASTIC_MID = ['length' => 20, 'width' => 18];

    const BUBBLE_PLASTIC_LARGE = ['length' => 21, 'width' => 28];

    const BAG_1 = ['length' => 16, 'width' => 23];

    const BAG_2 = ['length' => 25, 'width' => 35.3];

    const OFFICE = ['length' => 22.9, 'width' => 11.4];

    const CART_MID = ['length' => 35.3, 'width' => 25];

    const CART_LARGE = ['length' => 40, 'width' => 28];

    public function __construct(array $dimensions = self::BASE)
    {
        parent::__construct($dimensions);
    }

    /**
     * @param array $dimensions
     * @throws InvalidContainerDimensionsException
     * @throws MissingContainerDimensionException
     */
    public function validateDimensions(array $dimensions)
    {
        if (!isset($dimensions['width']) || !isset($dimensions['length'])) {
            throw new MissingContainerDimensionException;
        } elseif (!($this->isBetween(
            $dimensions['width'],
            $this->minDimensions['width'],
            $this->maxDimensions['width']
        )) ||
            !($this->isBetween($dimensions['length'], $this->minDimensions['length'], $this->maxDimensions['length']))
        ) {
            throw new InvalidContainerDimensionsException;
        }
    }
}
