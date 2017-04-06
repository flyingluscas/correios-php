<?php

namespace FlyingLuscas\Correios;

use GuzzleHttp\Client as HttpClient;
use FlyingLuscas\Correios\Services\Freight;
use FlyingLuscas\Correios\Contracts\FreightInterface;

class Client
{
    /**
     * Serviço de frete.
     *
     * @var \FlyingLuscas\Correios\Contracts\FreightInterface
     */
    protected $freight;

    /**
     * Creates a new Client instance.
     *
     * @param \FlyingLuscas\Correios\Contracts\FreightInterface|null $freight
     */
    public function __construct(FreightInterface $freight = null)
    {
        $this->freight = $freight ?: new Freight(new HttpClient);
    }

    /**
     * Serviço de frete dos Correios.
     *
     * @return \FlyingLuscas\Correios\Contracts\FreightInterface
     */
    public function freight()
    {
        return $this->freight;
    }
}
