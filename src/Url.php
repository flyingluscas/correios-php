<?php

namespace FlyingLuscas\Correios;

abstract class Url
{
    /**
     * Price url.
     */
    const PRICE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPreco';

    /**
     * Deadline url.
     */
    const DEADLINE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrazo';

    /**
     * Price and deadline url.
     */
    const PRICE_DEADLINE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
}
