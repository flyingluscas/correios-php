<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Contracts\CalculableFreightDimensions;

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
     * @var \FlyingLuscas\Correios\Contracts\CalculableFreightDimensions
     */
    protected $items;

    /**
     * Creates a new class instance.
     *
     * @param CalculableFreightDimensions $items
     */
    public function __construct(CalculableFreightDimensions $items)
    {
        $this->items = $items;
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
     * Dimensões, peso e quantidade do item.
     *
     * @param  int|float $width
     * @param  int|float $height
     * @param  int|float $length
     * @param  int|float $weight
     * @param  int       $quantity
     *
     * @return self
     */
    public function item($width, $height, $length, $weight, $quantity = 1)
    {
        $this->items[] = compact('width', 'height', 'length', 'weight', 'quantity');

        return $this;
    }
}
