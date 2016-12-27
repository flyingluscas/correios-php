# Correios PHP SDK

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![StyleCI][icon-styleci]][link-styleci]
[![Coverage Status][ico-code-climate]][link-code-climate]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Uma maneira fácil de usar o cálculo de frete dos [Correios] (http://www.correios.com.br) para vários itens.

## Instalação

Via Composer

``` bash
$ composer require flyingluscas/correios-php
```

## Uso

``` php
use FlyingLuscas\Correios\Format;
use FlyingLuscas\Correios\Freight;
use FlyingLuscas\Correios\Service;

$freight = new Freight;

$freight->setServices(Service::SEDEX, Service::PAC);
$freight->setZipCodes('01001-000', '87047-230');

$freight->cart->fill([
    [
        'width' => 16,
        'height' => 16,
        'length' => 16,
        'weight' => 0.3,
        'quantity' => 1,
    ],
    [
        'width' => 16,
        'height' => 16,
        'length' => 16,
        'weight' => 0.3,
        'quantity' => 3,
    ],
]);

$results = $freight->calculate();
```

## Change log

Consulte [CHANGELOG](CHANGELOG.md) para obter mais informações sobre o que mudou recentemente.

## Testando

``` bash
$ composer test
```

## Contribuindo

Consulte [CONTRIBUTING](CONTRIBUTING.md) para obter mais detalhes.

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
