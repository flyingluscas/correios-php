<?php

namespace FlyingLuscas\Correios\Contracts;

interface ObjectsInterface
{
    /**
     * Recupera a maior lagura entre os objetos.
     *
     * @return int|float
     */
    public function width();

    /**
     * Recupera a altura total de todos os objetos.
     *
     * @return int|float
     */
    public function height();
}
