<?php

namespace FlyingLuscas\Correios;

use Mockery;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}
