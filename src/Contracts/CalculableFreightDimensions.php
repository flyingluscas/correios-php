<?php

namespace FlyingLuscas\Correios\Contracts;

interface CalculableFreightDimensions
{
    /**
     * Maior largura entre todos os itens.
     *
     * @return int|float
     */
    public function width();

    /**
     * Soma da altura de todos os itens em conjunto.
     *
     * @return int|float
     */
    public function height();

    /**
     * Maior comprimento entre todos os itens.
     *
     * @return int|float
     */
    public function length();

    /**
     * Soma do peso de todos os itens em conjunto.
     *
     * @return int|float
     */
    public function weight();

    /**
     * Volume total de todos os itens em conjunto.
     *
     * @return int|float
     */
    public function volume();
}
