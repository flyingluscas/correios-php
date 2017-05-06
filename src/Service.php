<?php

namespace FlyingLuscas\Correios;

abstract class Service
{
    /**
     * PAC.
     */
    const PAC = 41106;
    
    /**
     * PAC sem contrato.
     */
    const PAC_SEM_CONTRATO = 04510;

    /**
     * Sedex.
     */
    const SEDEX = 40010;
    
    /**
     * SEDEX sem contrato.
     */
    const SEDEX_SEM_CONTRATO = 04014;

    /**
     * Sedex a Cobrar.
     */
    const SEDEX_A_COBRAR = 40045;

    /**
     * Sedex 10.
     */
    const SEDEX_10 = 40215;

    /**
     * Sedex Hoje.
     */
    const SEDEX_HOJE = 40290;
}
