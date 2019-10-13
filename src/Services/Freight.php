<?php

namespace FlyingLuscas\Correios\Services;

use SimpleXMLElement;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\WebService;
use FlyingLuscas\Correios\PackageType;
use FlyingLuscas\Correios\Contracts\FreightInterface;

class Freight implements FreightInterface
{
    /**
     * Serviços do Correios (Sedex, PAC...).
     *
     * @var array
     */
    protected $services = [];

    /**
     * Payload padrão.
     *
     * @var array
     */
    protected $defaultPayload = [
        'nCdEmpresa' => '',
        'sDsSenha' => '',
        'nCdServico' => '',
        'sCepOrigem' => '',
        'sCepDestino' => '',
        'nCdFormato' => PackageType::BOX,
        'nVlLargura' => 0,
        'nVlAltura' => 0,
        'nVlPeso' => 0,
        'nVlComprimento' => 0,
        'nVlDiametro' => 0,
        'sCdMaoPropria' => 'N',
        'nVlValorDeclarado' => 0,
        'sCdAvisoRecebimento' => 'N',
    ];

    /**
     * Payload da requisição.
     *
     * @var array
     */
    protected $payload = [];

    /**
     * Objetos a serem transportados.
     *
     * @var array
     */
    protected $items = [];

    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $http;

    /**
     * Creates a new class instance.
     *
     * @param \GuzzleHttp\ClientInterface $http
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @param  string $service Serviço (Sedex, PAC...)
     *
     * @return array
     */
    public function payload($service)
    {
        $this->payload['nCdServico'] = $service;

        if ($this->items) {
            $this->payload['nVlLargura'] = $this->width();
            $this->payload['nVlAltura'] = $this->height();
            $this->payload['nVlComprimento'] = $this->length();
            $this->payload['nVlDiametro'] = 0;
            $this->payload['nVlPeso'] = $this->useWeightOrVolume();
        }

        return array_merge($this->defaultPayload, $this->payload);
    }

    /**
     * CEP de origem.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function origin($zipCode)
    {
        $this->payload['sCepOrigem'] = preg_replace('/[^0-9]/', null, $zipCode);

        return $this;
    }

    /**
     * CEP de destino.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function destination($zipCode)
    {
        $this->payload['sCepDestino'] = preg_replace('/[^0-9]/', null, $zipCode);

        return $this;
    }

    /**
     * Serviços a serem calculados.
     *
     * @param  int ...$services
     *
     * @return self
     */
    public function services(...$services)
    {
        $this->services = array_unique($services);

        return $this;
    }

    /**
     * Código administrativo junto à ECT. O código está disponível no
     * corpo do contrato firmado com os Correios.
     *
     * Senha para acesso ao serviço, associada ao seu código administrativo,
     * a senha inicial corresponde aos 8 primeiros dígitos do CNPJ informado no contrato.
     *
     * @param  string $code
     * @param  string $password
     *
     * @return self
     */
    public function credentials($code, $password)
    {
        $this->payload['nCdEmpresa'] = $code;
        $this->payload['sDsSenha'] = $password;

        return $this;
    }

    /**
     * Formato da encomenda (Caixa, pacote, rolo, prisma ou envelope).
     *
     * @param  int $format
     *
     * @return self
     */
    public function package($format)
    {
        $this->payload['nCdFormato'] = $format;

        return $this;
    }

    /**
     * Indique se a encomenda será entregue com o serviço adicional mão própria.
     *
     * @param  bool $useOwnHand
     *
     * @return self
     */
    public function useOwnHand($useOwnHand)
    {
        $this->payload['sCdMaoPropria'] = (bool) $useOwnHand ? 'S' : 'N';

        return $this;
    }

    /**
     * Indique se a encomenda será entregue com o serviço adicional valor declarado,
     * deve ser apresentado o valor declarado desejado, em reais.
     *
     * @param  int|float $value
     *
     * @return self
     */
    public function declaredValue($value)
    {
        $this->payload['nVlValorDeclarado'] = floatval($value);

        return $this;
    }

    /**
     * Dimensões, peso e quantidade do item.
     *
     * @param  int|float $width
     * @param  int|float $height
     * @param  int|float $length
     * @param  int|float $weight
     * @param  int       $quantity
     *
     * @return self
     */
    public function item($width, $height, $length, $weight, $quantity = 1)
    {
        $this->items[] = compact('width', 'height', 'length', 'weight', 'quantity');

        return $this;
    }

    /**
     * Calcula preços e prazos junto ao Correios.
     *
     * @return array
     */
    public function calculate()
    {
        $servicesResponses = array_map(function ($service) {
            return $this->http->get(WebService::CALC_PRICE_DEADLINE, [
                'query' => $this->payload($service),
            ]);
        }, $this->services);


        $services = array_map([$this, 'fetchCorreiosService'], $servicesResponses);

        return array_map([$this, 'transformCorreiosService'], $services);
    }

    /**
     * Calcula e retorna a maior largura entre todos os itens.
     *
     * @return int|float
     */
    protected function width()
    {
        return max(array_map(function ($item) {
            return $item['width'];
        }, $this->items));
    }

    /**
     * Calcula e retorna a soma total da altura de todos os itens.
     *
     * @return int|float
     */
    protected function height()
    {
        return array_sum(array_map(function ($item) {
            return $item['height'] * $item['quantity'];
        }, $this->items));
    }

    /**
     * Calcula e retorna o maior comprimento entre todos os itens.
     *
     * @return int|float
     */
    protected function length()
    {
        return max(array_map(function ($item) {
            return $item['length'];
        }, $this->items));
    }

    /**
     * Calcula e retorna a soma total do peso de todos os itens.
     *
     * @return int|float
     */
    protected function weight()
    {
        return array_sum(array_map(function ($item) {
            return $item['weight'] * $item['quantity'];
        }, $this->items));
    }

    /**
     * Calcula o volume do frete com base no comprimento, largura e altura dos itens.
     *
     * @return int|float
     */
    protected function volume()
    {
        return ($this->length() * $this->width() * $this->height()) / 6000;
    }

    /**
     * Calcula qual valor (volume ou peso físico) deve ser
     * utilizado como peso do frete na requisição final.
     *
     * @return int|float
     */
    protected function useWeightOrVolume()
    {
        if ($this->volume() < 10 || $this->volume() <= $this->weight()) {
            return $this->weight();
        }
        return $this->volume();
    }

    /**
     * Extrai todos os serviços retornados no XML de resposta dos Correios.
     *
     * @param  \GuzzleHttp\Psr7\Response $response
     *
     * @return array
     */
    protected function fetchCorreiosService(Response $response)
    {
        $xml = simplexml_load_string($response->getBody()->getContents());
        $result = json_decode(json_encode($xml->Servicos));

        return get_object_vars($result->cServico);
    }

    /**
     * Transforma um serviço dos Correios em um array mais limpo,
     * legível e fácil de manipular.
     *
     * @param  array  $service
     *
     * @return array
     */
    protected function transformCorreiosService(array $service)
    {
        $error = [];

        if ($service['Erro'] != 0) {
            $error = [
                'code' => $service['Erro'],
                'message' => $service['MsgErro'],
            ];
        }

        return [
            'name' => $this->friendlyServiceName($service['Codigo']),
            'code' => $service['Codigo'],
            'price' => floatval(str_replace(',', '.', $service['Valor'])),
            'deadline' => intval($service['PrazoEntrega']),
            'error' => $error,
        ];
    }

    /**
     * Nome dos seviços (Sedex, PAC...) com base no código.
     *
     * @param  string $code
     *
     * @return string|null
     */
    protected function friendlyServiceName($code)
    {
        $id = intval($code);
        $services = [
            intval(Service::PAC) => 'PAC',
            intval(Service::PAC_CONTRATO) => 'PAC',
            intval(Service::PAC_CONTRATO_04812) => 'PAC',
            intval(Service::PAC_CONTRATO_41068) => 'PAC',
            intval(Service::PAC_CONTRATO_41211) => 'PAC',
            intval(Service::SEDEX) => 'Sedex',
            intval(Service::SEDEX_CONTRATO) => 'Sedex',
            intval(Service::SEDEX_A_COBRAR) => 'Sedex a Cobrar',
            intval(Service::SEDEX_10) => 'Sedex 10',
            intval(Service::SEDEX_HOJE) => 'Sedex Hoje',
            intval(Service::SEDEX_CONTRATO_04316) => 'Sedex',
            intval(Service::SEDEX_CONTRATO_40096) => 'Sedex',
            intval(Service::SEDEX_CONTRATO_40436) => 'Sedex',
            intval(Service::SEDEX_CONTRATO_40444) => 'Sedex',
            intval(Service::SEDEX_CONTRATO_40568) => 'Sedex',
        ];

        if (array_key_exists($id, $services)) {
            return $services[$id];
        }

        return null;
    }
}
