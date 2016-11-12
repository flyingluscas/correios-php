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
     * Code of the company within the Correios.
     *
     * @var string
     */
    protected $companyCode;

    /**
     * Password of the company within the Correios.
     *
     * @var string
     */
    protected $companyPassword;

    /**
     * Set the company credentials within the Correios.
     *
     * @param string $code
     * @param string $password
     *
     * @return self
     */
    public function setCredentials($code, $password)
    {
        $this->setCompanyCode($code)->setCompanyPassword($password);

        return $this;
    }

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
     * Set the company password.
     *
     * @param string $code Password of the company within the Correios.
     */
    public function setCompanyPassword($password)
    {
        $this->companyPassword = $password;

        return $this;
    }

    /**
     * Get the company password.
     *
     * @return string|null
     */
    public function getCompanyPassword()
    {
        return $this->companyPassword;
    }

    /**
     * Set the company code.
     *
     * @param string $code Code of the company within the Correios.
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
