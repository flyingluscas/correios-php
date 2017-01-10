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

    protected $originZipCode;

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

    public function setZipCodes($origin, $destiny)
    {
        $this->originZipCode = preg_replace('/[^0-9]/', null, $origin);
        $this->destinyZipCode = preg_replace('/[^0-9]/', null, $destiny);

        return $this;
    }

    public function getOriginZipCode()
    {
        return $this->originZipCode;
    }

    public function getDestinyZipCode()
    {
        return $this->destinyZipCode;
    }
}
