<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Payload da requisição.
     *
     * @var array
     */
    protected $payload = [];

    /**
     * Objetos a serem transportados.
     *
     * @var array
     */
    public $items = [];

    /**
     * CEP de origem.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function origin($zipCode)
    {
        $this->payload['sCepOrigem'] = preg_replace('/[^0-9]/', null, $zipCode);

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
        $this->payload['sCepDestino'] = preg_replace('/[^0-9]/', null, $zipCode);

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
        $this->payload['nCdServico'] = implode(',', $services);

        return $this;
    }

    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @return array
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * Objeto que será transportado.
     *
     * @param  int|float $width
     * @param  int|float $height
     * @param  int|float $length
     * @param  int|float $weight
     * @param  int       $quantity
     *
     * @return self
     */
    public function item($width, $height, $length, $weight, $quantity)
    {
        $this->items[] = compact(
            'width', 'height', 'length', 'weight', 'quantity'
        );

        return $this;
    }
}
