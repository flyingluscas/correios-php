<?php

namespace FlyingLuscas\Correios;

abstract class Service
{
    /**
     * Código de serviço do PAC.
     */
    const PAC = 41106;

    /**
     * Código de serviço do Sedex.
     */
    const SEDEX = 40010;

    /**
     * Código de serviço do Sedex a cobrar.
     */
    const SEDEX_A_COBRAR = 40045;

    /**
     * Código de serviço do Sedex 10.
     */
    const SEDEX_10 = 40215;

    /**
     * Código de serviço do Sedex hoje.
     */
    const SEDEX_HOJE = 40290;
}
