<?php

namespace FlyingLuscas\Correios;

abstract class Url
{
    /**
     * Url para cálculo de preços dos Correios.
     */
    const PRICE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPreco';

    /**
     * Url para cálculo de prazos dos Correios.
     */
    const DEADLINE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrazo';

    /**
     * Url para cálculo de preços e prazos dos Correios.
     */
    const PRICE_DEADLINE = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
}
