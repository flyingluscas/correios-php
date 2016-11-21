<?php

namespace FlyingLuscas\Correios\Exceptions;

/**
 * Class OverflowMaxContainerSizeException
 * @package FlyingLuscas\Correios\Exceptions
 */
class OverflowMaxContainerSizeException extends \Exception
{
    /**
     * OverflowMaxContainerSizeException constructor.
     * @param string $max
     * @param int $current
     */
    public function __construct($max, $current)
    {
        parent::__construct(
            sprintf(
                'Overflow max container size! The max size is %s CM your current container is %s CM',
                $max,
                $current
            ),
            1003,
            null
        );
    }
}
