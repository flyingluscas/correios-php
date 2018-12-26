<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\TestCase;
use GuzzleHttp\Client as HttpClient;

class ZipCodeTest extends TestCase
{
    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    public function setUp()
    {
        parent::setUp();

        $this->http = new HttpClient;
    }

    public function testNotFoundZipCode()
    {
        $zipcode = new ZipCode($this->http);

        $this->assertEquals([
            'error' => 'CEP não encontrado',
        ], $zipcode->find('99999-999'));
    }

    public function testFindAddressByZipCode()
    {
        $zipcode = new ZipCode($this->http);

        $this->assertEquals([
            'zipcode' => '01001-000',
            'street' => 'Praça da Sé',
            'complement' => ['- lado ímpar'],
            'district' => 'Sé',
            'city' => 'São Paulo',
            'uf' => 'SP',
        ], $zipcode->find('01001-000'));
    }
}
