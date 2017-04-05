<?php

namespace FlyingLuscas\Correios\Services;

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
    protected $items = [];

    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @return array
     */
    public function payload()
    {
        return $this->setFreightDimensions()->payload;
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

    /**
     * Seta largura, altura, comprimento, peso e volume do frete.
     *
     * @return self
     */
    protected function setFreightDimensions()
    {
        if ($this->items) {
            $this->payload['nVlLargura'] = $this->width();
            $this->payload['nVlAltura'] = $this->height();
            $this->payload['nVlComprimento'] = $this->length();
            $this->payload['nVlDiametro'] = 0;
            $this->payload['nVlPeso'] = $this->useWeightOrVolume();
        }

        return $this;
    }

    /**
     * Calcula e retorna a maior largura entre todos os itens.
     *
     * @return int|float
     */
    protected function width()
    {
        return max(array_map(function ($item) {
            return $item['width'];
        }, $this->items));
    }

    /**
     * Calcula e retorna a soma total da altura de todos os itens.
     *
     * @return int|float
     */
    protected function height()
    {
        return array_sum(array_map(function ($item) {
            return $item['height'] * $item['quantity'];
        }, $this->items));
    }

    /**
     * Calcula e retorna o maior comprimento entre todos os itens.
     *
     * @return int|float
     */
    protected function length()
    {
        return max(array_map(function ($item) {
            return $item['length'];
        }, $this->items));
    }

    /**
     * Calcula e retorna a soma total do peso de todos os itens.
     *
     * @return int|float
     */
    protected function weight()
    {
        return array_sum(array_map(function ($item) {
            return $item['weight'] * $item['quantity'];
        }, $this->items));
    }

    /**
     * Calcula o volume do frete com base no comprimento, largura e altura dos itens.
     *
     * @return int|float
     */
    protected function volume()
    {
        return ($this->length() * $this->width() * $this->height()) / 6000;
    }

    /**
     * Calcula qual valor (volume ou peso físico) deve ser
     * utilizado como peso do frete na requisição final.
     *
     * @return int|float
     */
    protected function useWeightOrVolume()
    {
        if ($this->volume() < 10 || $this->volume() <= $this->weight()) {
            return $this->weight();
        }

        return $this->volume();
    }
}
