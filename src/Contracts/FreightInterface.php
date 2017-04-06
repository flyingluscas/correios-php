<?php

namespace FlyingLuscas\Correios\Contracts;

interface FreightInterface
{
    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @return array
     */
    public function payload();

    /**
     * CEP de origem.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function origin($zipCode);

    /**
     * CEP de destino.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function destination($zipCode);

    /**
     * Serviços a serem calculados.
     *
     * @param  int ...$services
     *
     * @return self
     */
    public function services(...$services);

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
    public function item($width, $height, $length, $weight, $quantity = 1);

    /**
     * Calcula preços e prazos junto ao Correios.
     *
     * @return array
     */
    public function calculate();
}
