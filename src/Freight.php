<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Correios services codes.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Company code within the Correios.
     *
     * @var string
     */
    protected $companyCode;

    /**
     * Creates a new class instance.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->setServices($services);
    }

    /**
     * Set the company code.
     *
     * @param string $code Company code within the Correios.
     *
     * @return self
     */
    public function setCompanyCode($code)
    {
        $this->companyCode = $code;

        return $this;
    }

    /**
     * Get company code.
     *
     * @return string|null
     */
    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    /**
     * Set services.
     *
     * @param mixed $service
     *
     * @return self
     */
    public function setServices($service)
    {
        $this->services = (is_array($service)) ? $service : func_get_args();

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
