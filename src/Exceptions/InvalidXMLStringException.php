<?php

namespace FlyingLuscas\Correios\Exceptions;

use Exception;

class InvalidXMLStringException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid XML String provided', 1000, null);
    }
}
