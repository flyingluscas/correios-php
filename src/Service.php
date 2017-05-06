<?php

namespace FlyingLuscas\Correios;

abstract class Service
{
    /**
     * PAC.
     */
    const PAC = '04510';
    
    /**
     * PAC com contrato.
     */
    const PAC_CONTRATO = '04669';

    /**
     * Sedex.
     */
    const SEDEX = '04014';
    
    /**
     * Sedex com contrato.
     */
    const SEDEX_CONTRATO = '04162';

    /**
     * Sedex a Cobrar.
     */
    const SEDEX_A_COBRAR = '40045';

    /**
     * Sedex 10.
     */
    const SEDEX_10 = '40215';

    /**
     * Sedex Hoje.
     */
    const SEDEX_HOJE = '40290';
}
