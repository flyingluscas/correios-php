<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Exceptions\InvalidFormatException;

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
     * Origin zip code.
     *
     * @var string
     */
    protected $originZipCode;

    /**
     * Correios format.
     *
     * @var int
     */
    protected $format;

    /**
     * Destiny zip code.
     *
     * @var string
     */
    protected $destinyZipCode;

    /**
     * Set the Correios format.
     *
     * @param int $format
     *
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get Correios format.
     *
     * @return int|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set origin and destiny zip codes.
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
     * Get origin zip code.
     *
     * @return string|null
     */
    public function getOriginZipCode()
    {
        return $this->originZipCode;
    }

    /**
     * Get destiny zip code.
     *
     * @return string|null
     */
    public function getDestinyZipCode()
    {
        return $this->destinyZipCode;
    }

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
