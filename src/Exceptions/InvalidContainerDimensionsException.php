<?php

namespace FlyingLuscas\Correios\Exceptions;

use Exception;

/**
 * Class InvalidContainerDimensionsException
 * @package Exceptions
 */
class InvalidContainerDimensionsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Check your container dimensions!', 1001, null);
    }
}
