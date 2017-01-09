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
}
