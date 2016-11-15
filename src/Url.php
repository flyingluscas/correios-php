<?php

namespace FlyingLuscas\Correios;

abstract class Url
{
    /**
     * Tracking url.
     */
    const TRACKING = 'https://webservice.correios.com.br/service/rastro/Rastro.wsdl';

    /**
     * Price and deadline url.
     */
    const PRICE_DEADLINE = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx';

    /**
     * Zip code url.
     */
    const ZIP_CODE = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';
}
