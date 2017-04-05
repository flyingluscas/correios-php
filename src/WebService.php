<?php

namespace FlyingLuscas\Correios;

abstract class WebService
{
    /**
     * URL do webservice dos Correios para calculo de preços e prazos.
     */
    const URL = '//ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
}
