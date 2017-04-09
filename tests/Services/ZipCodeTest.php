<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\TestCase;

class ZipCodeTest extends TestCase
{
    public function testNotFoundZipCode()
    {
        $body = __DIR__.'/../XMlSamples/ZipCodeNotFoundErrorResponse.xml';
        $http = $this->mockHttpClient($body);

        $zipcode = new ZipCode($http);

        $this->assertEquals([
            'error' => 'CEP não encontrado',
        ], $zipcode->find('99999-999'));
    }

    public function testFindAddressByZipCode()
    {
        $body = __DIR__.'/../XMlSamples/ZipCodeResponse.xml';
        $http = $this->mockHttpClient($body);

        $zipcode = new ZipCode($http);

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
