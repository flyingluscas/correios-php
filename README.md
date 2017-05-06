# Correios PHP SDK

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![StyleCI][icon-styleci]][link-styleci]
[![Coverage Status][ico-code-climate]][link-code-climate]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Uma maneira fácil de interagir com as principais funcionalidades dos [Correios](https://correios.com.br).

## Funcionalidades

- [Consultar CEP](#consultar-cep)
- [Calcular Preços e Prazos](#calcular-preços-e-prazos)

## Instalação

Via Composer

``` bash
$ composer require flyingluscas/correios-php
```

## Uso

### Consultar CEP

Encontrar endereço pelo CEP consultando diretamente o [WebService][correios-sigep] dos Correios.

``` php
use FlyingLuscas\Correios\Client;

require 'vendor/autoload.php';

$correios = new Client;

$correios->zipcode()
    ->find('01001-000');

/*

Resultado:

[
    'zipcode' => '01001-000',
    'street' => 'Praça da Sé',
    'complement' => [
        'lado ímpar',
    ],
    'district' => 'Sé',
    'city' => 'São Paulo',
    'uf' => 'SP',
]
*/
```

### Calcular Preços e Prazos

Calcular preços e prazos de serviços de entrega (Sedex, PAC e etc), com **suporte a multiplos objetos** na mesma consulta.

``` php
use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;

require 'vendor/autoload.php';

$correios = new Client;

$correios->freight()
    ->origin('01001-000')
    ->destination('87047-230')
    ->services(Service::SEDEX, Service::PAC)
    ->item(16, 16, 16, .3, 1) // largura, altura, comprimento, peso e quantidade
    ->item(16, 16, 16, .3, 3) // largura, altura, comprimento, peso e quantidade
    ->item(16, 16, 16, .3, 2) // largura, altura, comprimento, peso e quantidade
    ->calculate();

/*

Resultados:

[
    [
        'name' => 'Sedex',
        'code' => 40010,
        'price' => 51,
        'deadline' => 4,
        'error' => [],
    ],
    [
        'name' => 'PAC',
        'code' => 41106,
        'price' => 22.5,
        'deadline' => 9,
        'error' => [],
    ],
]
*/
```

## Change log

Consulte [CHANGELOG](.github/CHANGELOG.md) para obter mais informações sobre o que mudou recentemente.

## Testando

``` bash
$ composer test
```

## Contribuindo

Consulte [CONTRIBUTING](.github/CONTRIBUTING.md) para obter mais detalhes.

## Segurança

Se você descobrir quaisquer problemas relacionados à segurança, envie um e-mail para lucas.pires.mattos@gmail.com em vez de usar as issues.

## Créditos

- [Lucas Pires][link-author]
- [Todos os contribuidores][link-contributors]

## Licença

A Licença MIT (MIT). Consulte o [arquivo de licença](LICENSE.md) para obter mais informações.

[ico-version]: https://img.shields.io/packagist/v/flyingluscas/correios-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/flyingluscas/correios-php/master.svg?style=flat-square
[icon-styleci]: https://styleci.io/repos/72848778/shield?branch=master
[ico-code-climate]: https://img.shields.io/codeclimate/coverage/github/flyingluscas/correios-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/codeclimate/github/flyingluscas/correios-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/flyingluscas/correios-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/flyingluscas/correios-php
[link-travis]: https://travis-ci.org/flyingluscas/correios-php
[link-styleci]: https://styleci.io/repos/72848778
[link-code-climate]: https://codeclimate.com/github/flyingluscas/correios-php/coverage
[link-code-quality]: https://codeclimate.com/github/flyingluscas/correios-php/code
[link-downloads]: https://packagist.org/packages/flyingluscas/correios-php
[link-author]: https://github.com/flyingluscas
[link-contributors]: ../../contributors

[correios-sigep]: https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl
