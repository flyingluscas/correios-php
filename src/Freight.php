<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * CEP de origem.
     *
     * @var string
     */
    protected $origin;

    /**
     * CEP de destino.
     *
     * @var string
     */
    protected $destination;

    /**
     * Serviços (Sedex, PAC...)
     *
     * @var string
     */
    protected $services;

    /**
     * CEP de origem.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function origin($zipCode)
    {
        $this->origin = preg_replace('/[^0-9]/', null, $zipCode);

        return $this;
    }

    /**
     * CEP de destino.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function destination($zipCode)
    {
        $this->destination = preg_replace('/[^0-9]/', null, $zipCode);

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
            'sCepDestino' => $this->destination,
        ];
    }
}
