<?php

namespace FlyingLuscas\Correios;

use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        error_reporting(E_ALL);
    }
}
