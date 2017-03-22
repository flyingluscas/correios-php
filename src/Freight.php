<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Serviços (Sedex, PAC...)
     *
     * @var array
     */
    protected $services = [];

    /**
     * Serviços a serem calculados.
     *
     * @param  int ...$services
     *
     * @return self
     */
    public function services(...$services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @return array
     */
    public function payload()
    {
        return [
            'nCdServico' => implode(',', $this->services),
        ];
    }
}
