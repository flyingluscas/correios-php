<?php

namespace FlyingLuscas\Correios;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as HttpClient;
use FlyingLuscas\Correios\Services\Freight;
use FlyingLuscas\Correios\Services\ZipCode;
use FlyingLuscas\Correios\Contracts\FreightInterface;
use FlyingLuscas\Correios\Contracts\ZipCodeInterface;

class Client
{
    /**
     * Serviço de frete.
     *
     * @var \FlyingLuscas\Correios\Contracts\FreightInterface
     */
    protected $freight;

    /**
     * Serviço de CEP.
     *
     * @var \FlyingLuscas\Correios\Contracts\ZipCodeInterface
     */
    protected $zipcode;

    /**
     * Cria uma nova instância da classe Client.
     *
     * @param \GuzzleHttp\ClientInterface|null  $http
     * @param \FlyingLuscas\Correios\Contracts\FreightInterface|null $freight
     * @param \FlyingLuscas\Correios\Contracts\ZipCodeInterface|null $zipcode
     */
    public function __construct(
        ClientInterface $http = null,
        FreightInterface $freight = null,
        ZipCodeInterface $zipcode = null
    ) {
        $this->http = $http ?: new HttpClient;
        $this->freight = $freight ?: new Freight($this->http);
        $this->zipcode = $zipcode ?: new ZipCode($this->http);
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

    /**
     * Serviço de CEP dos Correios.
     *
     * @return \FlyingLuscas\Correios\Contracts\ZipCodeInterface
     */
    public function zipcode()
    {
        return $this->zipcode;
    }
}
