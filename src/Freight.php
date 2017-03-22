<?php

namespace FlyingLuscas\Correios;

class Freight
{
    protected $origin;

    /**
     * Serviços (Sedex, PAC...)
     *
     * @var string
     */
    protected $services;

    public function origin($zipCode)
    {
        $this->origin = preg_replace('/[^0-9]/', null, $zipCode);

        return $this;
    }

    /**
     * Serviços a serem calculados.
     *
     * @param  int ...$services
     *
     * @return self
     */
    public function services(...$services)
    {
        $this->services = implode(',', $services);

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
            'sCepOrigem' => $this->origin,
            'nCdServico' => $this->services,
        ];
    }
}
