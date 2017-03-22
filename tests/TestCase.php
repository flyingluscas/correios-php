<?php

namespace FlyingLuscas\Correios;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}
