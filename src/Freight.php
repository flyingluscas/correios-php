<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Contracts\FreightObjectsInterface;

class Freight
{
    /**
     * Códigos dos serviços (Sedex, PAC...) a serem calculados.
     *
     * @var string
     */
    protected $services;

    /**
     * CEP de origem.
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
     * Objetos e suas dimensões.
     *
     * @var \FlyingLuscas\Correios\Contracts\FreightObjectsInterface
     */
    public $objects;

    /**
     * Create a new class instance.
     *
     * @param FreightObjectsInterface|null $objects
     */
    public function __construct(FreightObjectsInterface $objects = null)
    {
        $this->objects = $objects ?: new Objects;
    }

    /**
     * Códigos dos serviços (Sedex, PAC...) a serem calculados.
     *
     * @param int $service,...
     *
     * @return self
     */
    public function services(...$service)
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
     * CEP de origem e destino.
     *
     * @param string $origin
     * @param string $destiny
     *
     * @return self
     */
    public function zipCodes($origin, $destiny)
    {
        $this->originZipCode = preg_replace('/[^0-9]/', null, $origin);
        $this->destinyZipCode = preg_replace('/[^0-9]/', null, $destiny);

        return $this;
    }

    /**
     * Recupera CEP de origem.
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
