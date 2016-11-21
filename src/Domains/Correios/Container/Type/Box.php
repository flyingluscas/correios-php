<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container\Type;

use FlyingLuscas\Correios\Domains\Correios\Container\AbstractContainer;
use FlyingLuscas\Correios\Exceptions\InvalidContainerDimensionsException;
use FlyingLuscas\Correios\Exceptions\MissingContainerDimensionException;
use FlyingLuscas\Correios\Exceptions\OverflowMaxContainerSizeException;

/**
 * Class Box
 * @package FlyingLuscas\Correios\Domains\Correios\Container\Type
 */
class Box extends AbstractContainer
{
    protected $minDimensions = [
        'length'    => 16,
        'width'     => 11,
        'height'    => 2
    ];

    protected $maxDimensions = [
        'length'    => 105,
        'width'     => 105,
        'height'    => 105
    ];

    const ORDER_FLEX = ['length' => 26, 'width' => 21, 'height' => 6];

    const ORDER_1 = ['length' => 18, 'width' => 13.5, 'height' => 9];

    const ORDER_2 = ['length' => 27, 'width' => 18, 'height' => 9];

    const ORDER_3 = ['length' => 27, 'width' => 22.5, 'height' => 13.5];

    const ORDER_4 = ['length' => 36, 'width' => 27, 'height' => 18];

    const ORDER_5 = ['length' => 54, 'width' => 36, 'height' => 27];

    const ORDER_6 = ['length' => 27, 'width' => 27, 'height' => 36];

    const ORDER_7 = ['length' => 36, 'width' => 28, 'height' => 4];

    public function __construct(array $dimensions = self::ORDER_FLEX)
    {
        parent::__construct($dimensions);
    }

    /**
     * @param array $dimensions
     * @throws InvalidContainerDimensionsException
     * @throws MissingContainerDimensionException
     * @throws OverflowMaxContainerSizeException
     */
    public function validateDimensions(array $dimensions)
    {
        if (!isset($dimensions['width']) || !isset($dimensions['height']) || !isset($dimensions['length'])) {
            throw new MissingContainerDimensionException;
        } elseif (!($this->isBetween(
            $dimensions['width'],
            $this->minDimensions['width'],
            $this->maxDimensions['width']
        )) ||
            !($this->isBetween(
                $dimensions['height'],
                $this->minDimensions['height'],
                $this->maxDimensions['height']
            )) ||
            !($this->isBetween(
                $dimensions['length'],
                $this->minDimensions['length'],
                $this->maxDimensions['length']
            ))
        ) {
            throw new InvalidContainerDimensionsException;
        } elseif (($this->getWidth() + $this->getHeight() + $this->getLength()) > 200) {
            throw new OverflowMaxContainerSizeException(
                200,
                ($this->getWidth() + $this->getHeight() + $this->getLength())
            );
        }
    }
}
