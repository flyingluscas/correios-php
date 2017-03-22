<?php

namespace FlyingLuscas\Correios;

class Correios
{
    /**
     * Cálculo de frete.
     *
     * @return \FlyingLuscas\Correios\Freight
     */
    public static function freight()
    {
        return new Freight;
    }
}
