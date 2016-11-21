<?php

namespace FlyingLuscas\Correios\Support\Traits;

/**
 * Class HelperFunctions
 * @package FlyingLuscas\Correios\Support\Traits
 */
trait HelperFunctions
{
    /**
     * Check if the passed value is between start and end values inclusive or not
     *
     * @param $value
     * @param $start
     * @param $end
     * @param bool $inclusive
     * @return bool
     */
    public function isBetween($value, $start, $end, $inclusive = true)
    {
        if($value == null || $start == null || $end == null) {
            return false;
        } else {
            if(!$inclusive)
                return ($value > $start) && ($value < $end);
            else
                return ($value >= $start) && ($value <= $end);
        }
    }
}