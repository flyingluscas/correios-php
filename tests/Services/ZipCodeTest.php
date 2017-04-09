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
}
