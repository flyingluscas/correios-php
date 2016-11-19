<?php

namespace FlyingLuscas\Correios;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use FlyingLuscas\Correios\Contracts\CartInterface;
use FlyingLuscas\Correios\Support\Traits\XMLParser;
use FlyingLuscas\Correios\Support\FreightUrlBuilder;
use FlyingLuscas\Correios\Contracts\UrlBuilderInterface;

class Freight
{
    use XMLParser;

    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Cart fo items.
     *
     * @var \FlyingLuscas\Correios\Cart
     */
    public $cart;

    /**
     * Correios services codes.
     *
     * @var array
     */
    protected $services = [
        Service::SEDEX, Service::PAC,
    ];

    /**
     * Code of the company within the Correios.
     *
     * @var string
     */
    protected $companyCode = '';

    /**
     * Password of the company within the Correios.
     *
     * @var string
     */
    protected $companyPassword = '';

    /**
     * Correios format.
     *
     * @var int
     */
    protected $format = Format::BOX;

    /**
     * Use own hand.
     *
     * @var string
     */
    protected $ownHand = 'N';

    /**
     * Origin zip code.
     *
     * @var string
     */
    protected $originZipCode;

    /**
     * Destiny zip code.
     *
     * @var string
     */
    protected $destinyZipCode;

    /**
     * Declared value.
     *
     * @var int|float
     */
    protected $declaredValue = 0;

    /**
     * Notice of receipt.
     *
     * @var string
     */
    protected $noticeOfReceipt = 'N';

    /**
     * Creates a new Freight instance.
     *
     * @param \FlyingLuscas\Correios\Contracts\CartInterface|null $cart
     * @param \GuzzleHttp\ClientInterface|null                    $http
     */
    public function __construct(CartInterface $cart = null, ClientInterface $http = null)
    {
        $this->cart = $cart ?: new Cart;
        $this->http = $http ?: new Client;
    }

    /**
     * Does a request to the Correios webservice
     * to calculate the price and deadline of the freight.
     *
     * @param  \FlyingLuscas\Correios\Contracts\UrlBuilderInterface|null $urlBuilder
     *
     * @return array
     */
    public function calculate(UrlBuilderInterface $urlBuilder = null)
    {
        $urlBuilder = $urlBuilder ?: new FreightUrlBuilder($this);

        $response = $this->http->request('GET', $urlBuilder->makeUrl());
        $response = $this->convertXMLToArray($response->getBody()->getContents());

        return $this->transform($response);
    }

    /**
     * Transform response data in to readable results.
     *
     * @param  array  $data
     *
     * @return array
     */
    protected function transform(array $data)
    {
        if (array_key_exists('Codigo', $data['Servicos']['cServico'])) {
            return [
                $this->transformService($data['Servicos']['cServico'])
            ];
        }

        foreach ($data['Servicos']['cServico'] as $service) {
            $results[] = $this->transformService($service);
        }

        return $results;
    }

    /**
     * Transform a single service.
     *
     * @param  array  $service
     *
     * @return array
     */
    protected function transformService(array $service)
    {
        return [
            'service' => intval($service['Codigo']),
            'value' => floatval(str_replace(',', '.', $service['Valor'])),
            'deadline' => intval($service['PrazoEntrega']),
            'own_hand_value' => floatval(str_replace(',', '.', $service['ValorMaoPropria'])),
            'notice_receipt_value' => floatval(str_replace(',', '.', $service['ValorAvisoRecebimento'])),
            'declared_value' => floatval(str_replace(',', '.', $service['ValorValorDeclarado'])),
            'home_delivery' => $service['EntregaDomiciliar'] == 'S',
            'saturday_delivery' => $service['EntregaSabado'] == 'S',
            'error' => [
                'code' => $service['Erro'],
                'message' => $service['MsgErro'] ?: null,
            ],
        ];
    }

    /**
     * Set notice of receipt.
     *
     * @param bool $noticeOfReceipt
     *
     * @return self
     */
    public function setNoticeOfReceipt($noticeOfReceipt)
    {
        $this->noticeOfReceipt = ($noticeOfReceipt === true) ? 'S' : 'N';

        return $this;
    }

    /**
     * Get notice of receipt.
     *
     * @return string
     */
    public function getNoticeOfReceipt()
    {
        return $this->noticeOfReceipt;
    }

    /**
     * Set declared value.
     *
     * @param int|float $value
     *
     * @return self
     */
    public function setDeclaredValue($value)
    {
        $this->declaredValue = $value;

        return $this;
    }

    /**
     * Get declared value.
     *
     * @return int|float
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * Set own hand.
     *
     * @param bool $value
     *
     * @return self
     */
    public function setOwnHand($ownHand)
    {
        $this->ownHand = ($ownHand === true) ? 'S' : 'N';

        return $this;
    }

    /**
     * Get own hand.
     *
     * @return string
     */
    public function getOwnHand()
    {
        return $this->ownHand;
    }

    /**
     * Set the Correios format.
     *
     * @param int $format
     *
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get Correios format.
     *
     * @return int|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set origin and destiny zip codes.
     *
     * @param string $origin
     * @param string $destiny
     *
     * @return self
     */
    public function setZipCodes($origin, $destiny)
    {
        $this->originZipCode = preg_replace('/[^0-9]/', null, $origin);
        $this->destinyZipCode = preg_replace('/[^0-9]/', null, $destiny);

        return $this;
    }

    /**
     * Get origin zip code.
     *
     * @return string|null
     */
    public function getOriginZipCode()
    {
        return $this->originZipCode;
    }

    /**
     * Get destiny zip code.
     *
     * @return string|null
     */
    public function getDestinyZipCode()
    {
        return $this->destinyZipCode;
    }

    /**
     * Set the company credentials within the Correios.
     *
     * @param string $code
     * @param string $password
     *
     * @return self
     */
    public function setCredentials($code, $password)
    {
        $this->setCompanyCode($code)->setCompanyPassword($password);

        return $this;
    }

    /**
     * Set the company password.
     *
     * @param string $code Password of the company within the Correios.
     */
    public function setCompanyPassword($password)
    {
        $this->companyPassword = $password;

        return $this;
    }

    /**
     * Get the company password.
     *
     * @return string|null
     */
    public function getCompanyPassword()
    {
        return $this->companyPassword;
    }

    /**
     * Set the company code.
     *
     * @param string $code Code of the company within the Correios.
     *
     * @return self
     */
    public function setCompanyCode($code)
    {
        $this->companyCode = $code;

        return $this;
    }

    /**
     * Get company code.
     *
     * @return string|null
     */
    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    /**
     * Set services.
     *
     * @param mixed $service
     *
     * @return self
     */
    public function setServices($service)
    {
        $services = (is_array($service)) ? $service : func_get_args();

        $this->services = array_unique($services);

        return $this;
    }

    /**
     * Get services.
     *
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }
}
