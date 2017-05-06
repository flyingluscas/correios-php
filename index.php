<?php

use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;

require 'vendor/autoload.php';

$correios = new Client;

$results = $correios->freight()
    ->origin('01001-000')
    ->destination('87047-230')
    ->services(Service::SEDEX, Service::PAC)
    ->item(16, 16, 16, .3, 1) // largura, altura, comprimento, peso e quantidade
    ->item(16, 16, 16, .3, 3) // largura, altura, comprimento, peso e quantidade
    ->item(16, 16, 16, .3, 2) // largura, altura, comprimento, peso e quantidade
    ->calculate();

var_dump($results);
