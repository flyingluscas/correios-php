<?php

namespace FlyingLuscas\Correios\Domains\Correios\Container;

use FlyingLuscas\Correios\Support\Traits\HelperFunctions;

/**
 * Class AbstractContainer
 * @package Domains\Correios\Format
 */
abstract class AbstractContainer implements Container
{
    use HelperFunctions;

    /**
     * @var float
     */
    protected $width;

    /**
     * @var float
     */
    protected $height;

    /**
     * @var float
     */
    protected $length;

    /**
     * @var float
     */
    protected $diameter;

    /**
     * @var array
     */
    protected $minDimensions = [];

    /**
     * @var array
     */
    protected $maxDimensions = [];

    /**
     * @var bool
     */
    protected $isValid = false;

    /**
     * AbstractContainer constructor.
     * @param int $width
     */
    public function __construct(array $dimensions)
    {
        $this->validateDimensions($dimensions);
        $this->setIsValid(true);
        $this->fill($dimensions);
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return float
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * @param float $diameter
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    /**
     * @return array
     */
    public function getMinDimensions()
    {
        return $this->minDimensions;
    }

    /**
     * @param array $minDimensions
     */
    public function setMinDimensions($minDimensions)
    {
        $this->minDimensions = $minDimensions;
    }

    /**
     * @return array
     */
    public function getMaxDimensions()
    {
        return $this->maxDimensions;
    }

    /**
     * @param array $maxDimensions
     */
    public function setMaxDimensions($maxDimensions)
    {
        $this->maxDimensions = $maxDimensions;
    }

    /**
     * Fill required dimensions
     *
     * @param array $dimensions
     */
    public function fill(array $dimensions)
    {
        foreach($dimensions as $property => $value) {
            if(in_array($property, ['width', 'height', 'length', 'diameter']))
                $this->{$property} = $value;
        }
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        try {
            $this->validateDimensions($this->getDimensions());
            return $this->isValid = true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param boolean $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * @return array
     */
    public function getDimensions()
    {
        return [
            'length' => $this->getLength(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'diameter' => $this->getDiameter(),
        ];
    }
}