<?php

namespace FlyingLuscas\Correios;

class Freight
{
    /**
     * Correios services codes.
     *
     * @var array
     */
    protected $services = [
        Service::SEDEX, Service::PAC,
    ];

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
    protected $format = Format::BOX;

    /**
     * Use own hand.
     *
     * @var string
     */
    protected $ownHand = 'N';

    /**
     * Destiny zip code.
     *
     * @var string
     */
    protected $destinyZipCode;

    /**
     * Declared value.
     *
     * @var int|float
     */
    protected $declaredValue = 0;

    /**
     * Notice of receipt.
     *
     * @var string
     */
    protected $noticeOfReceipt = 'N';

    /**
     * Set notice of receipt.
     *
     * @param bool $noticeOfReceipt
     *
     * @return self
     */
    public function setNoticeOfReceipt($noticeOfReceipt)
    {
        $this->noticeOfReceipt = ($noticeOfReceipt === true) ? 'S' : 'N';

        return $this;
    }

    /**
     * Get notice of receipt;
     *
     * @return string
     */
    public function getNoticeOfReceipt()
    {
        return $this->noticeOfReceipt;
    }

    /**
     * Set declared value.
     *
     * @param int|float $value
     *
     * @return self
     */
    public function setDeclaredValue($value)
    {
        $this->declaredValue = $value;

        return $this;
    }

    /**
     * Get declared value.
     *
     * @return int|float
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * Set own hand.
     *
     * @param bool $value
     *
     * @return self
     */
    public function setOwnHand($ownHand)
    {
        $this->ownHand = ($ownHand === true) ? 'S' : 'N';

        return $this;
    }

    /**
     * Get own hand.
     *
     * @return string
     */
    public function getOwnHand()
    {
        return $this->ownHand;
    }

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
