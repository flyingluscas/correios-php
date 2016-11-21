<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container\Type;

use FlyingLuscas\Correios\Domains\Correios\Container\AbstractContainer;
use FlyingLuscas\Correios\Exceptions\InvalidContainerDimensionsException;
use FlyingLuscas\Correios\Exceptions\MissingContainerDimensionException;
use FlyingLuscas\Correios\Exceptions\OverflowMaxContainerSizeException;

/**
 * Class Roll
 * @package FlyingLuscas\Correios\Domains\Correios\Container\Type
 */
class Roll extends AbstractContainer
{
    protected $minDimensions = [
        'length'    => 18,
        'diameter'  => 5,
    ];

    protected $maxDimensions = [
        'length'    => 105,
        'diameter'  => 91,
    ];

    const BASE = ['length' => 18, 'diameter' => 5];

    public function __construct(array $dimensions = self::BASE)
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
        if (!isset($dimensions['length']) || !isset($dimensions['diameter'])) {
            throw new MissingContainerDimensionException;
        } elseif (!($this->isBetween(
            $dimensions['diameter'],
            $this->minDimensions['diameter'],
            $this->maxDimensions['diameter']
        )) ||
            !($this->isBetween($dimensions['length'], $this->minDimensions['length'], $this->maxDimensions['length']))
        ) {
            throw new InvalidContainerDimensionsException;
        } elseif (($this->getDiameter() + $this->getLength()) > 200) {
            throw new OverflowMaxContainerSizeException(
                200,
                ($this->getDiameter() + $this->getLength())
            );
        }
    }
}
