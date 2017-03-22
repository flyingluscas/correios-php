<?php

namespace FlyingLuscas\Correios;

use Mockery;
use PHPUnit_Framework_TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}
