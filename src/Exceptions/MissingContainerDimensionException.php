<?php

namespace FlyingLuscas\Correios\Exceptions;

/**
 * Class MissingContainerDimensionException
 * @package FlyingLuscas\Correios\Exceptions
 */
class MissingContainerDimensionException extends \Exception
{
    /**
     * MissingContainerDimensionException constructor.
     */
    public function __construct()
    {
        parent::__construct('Missing a required container dimension', 1002, null);
    }
}
