<?php

namespace FlyingLuscas\Correios\Support;

use FlyingLuscas\Correios\Domains\Correios\Freight\Freight;
use FlyingLuscas\Correios\Contracts\UrlBuilderInterface;
use FlyingLuscas\Correios\Domains\Correios\Freight\Url;

class FreightUrlBuilder implements UrlBuilderInterface
{
    /**
     * Freight.
     *
     * @var Freight
     */
    protected $freight;

    /**
     * Creates a new FreightUrlBuilder instance.
     *
     * @param Freight $freight
     */
    public function __construct(Freight $freight)
    {
        $this->freight = $freight;
    }

    /**
     * Build the request url.
     *
     * @return string
     */
    public function makeUrl()
    {
        return sprintf('%s?%s', Url::PRICE_DEADLINE, http_build_query($this->getParameters()));
    }

    /**
     * Get Correios parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        $parameters['nCdEmpresa'] = $this->freight->getCompanyCode();
        $parameters['sDsSenha'] = $this->freight->getCompanyPassword();
        $parameters['nCdServico'] = implode(',', $this->freight->getServices());
        $parameters['sCepOrigem'] = $this->freight->getOriginZipCode();
        $parameters['sCepDestino'] = $this->freight->getDestinyZipCode();
        $parameters['nCdFormato'] = $this->freight->getFormat();
        $parameters['nVlComprimento'] = $this->freight->cart->getMaxLength();
        $parameters['nVlAltura'] = $this->freight->cart->getTotalHeight();
        $parameters['nVlLargura'] = $this->freight->cart->getMaxWidth();
        $parameters['nVlDiametro'] = 0;
        $parameters['sCdMaoPropria'] = $this->freight->getOwnHand();
        $parameters['nVlValorDeclarado'] = $this->freight->getDeclaredValue();
        $parameters['sCdAvisoRecebimento'] = $this->freight->getNoticeOfReceipt();

        $volume = $this->freight->cart->getTotalVolume();
        $weight = $this->freight->cart->getTotalWeight();

        $parameters['nVlPeso'] = ($volume < 10 || $volume <= $weight ? $weight : $volume);

        return $parameters;
    }
}
