<?php

namespace FlyingLuscas\Correios;

abstract class Url
{
    /**
     * Base url Correios webservice.
     */
    const BASE = 'http://ws.correios.com.br';

    /**
     * Price and deadline url.
     */
    const PRICE_DEADLINE = 'calculador/CalcPrecoPrazo.asmx';
}
