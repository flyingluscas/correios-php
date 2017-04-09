<?php

namespace FlyingLuscas\Correios\Contracts;

interface ZipCodeInterface
{
    /**
     * Encontrar endereço por CEP.
     *
     * @param  string $zipcode
     *
     * @return array
     */
    public function find($zipcode);
}
