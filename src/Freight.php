<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Códigos dos serviços (Sedex, PAC...) a serem calculados.
     *
     * @var string
     */
    protected $services;

    /**
     * CEP de origin.
     *
     * @var string
     */
    protected $originZipCode;

    /**
     * CEP de destino.
     *
     * @var string
     */
    protected $destinyZipCode;

    /**
     * Códigos dos serviços (Sedex, PAC...) a serem calculados.
     *
     * @param int $service,...
     *
     * @return self
     */
    public function setServices(...$service)
    {
        $this->services = implode(',', $service);

        return $this;
    }

    /**
     * Recupera serviços configurados.
     *
     * @return string
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * CEP de origin e destino.
     *
     * @param string $origin
     * @param string $destiny
     *
     * @return self
     */
    public function setZipCodes($origin, $destiny)
    {
        $this->originZipCode = preg_replace('/[^0-9]/', null, $origin);
        $this->destinyZipCode = preg_replace('/[^0-9]/', null, $destiny);

        return $this;
    }

    /**
     * Recupera CEP de origin.
     *
     * @return string
     */
    public function getOriginZipCode()
    {
        return $this->originZipCode;
    }

    /**
     * Recupera CEP de destino.
     *
     * @return string
     */
    public function getDestinyZipCode()
    {
        return $this->destinyZipCode;
    }
}
