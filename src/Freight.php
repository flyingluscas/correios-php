<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Services codes.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Set services.
     *
     * @param mixed $service
     *
     * @return self
     */
    public function setServices($service)
    {
        if (is_array($service)) {
            $this->services = $service;
        } else {
            $this->services = func_get_args();
        }

        return $this;
    }

    /**
     * Get services.
     *
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }
}
