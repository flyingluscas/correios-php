<?php

namespace FlyingLuscas\Correios\Services;

use GuzzleHttp\ClientInterface;
use FlyingLuscas\Correios\WebService;
use FlyingLuscas\Correios\Contracts\ZipCodeInterface;

class ZipCode implements ZipCodeInterface
{
    /**
     * Cliente HTTP
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $http;

    /**
     * CEP
     *
     * @var string
     */
    protected $zipcode;

    /**
     * XML da requisição.
     *
     * @var string
     */
    protected $body;

    /**
     * Resposta da requisição.
     *
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * XML de resposta formatado.
     *
     * @var array
     */
    protected $parsedXML;

    /**
     * Cria uma nova instância da classe ZipCode.
     *
     * @param ClientInterface $http
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * Encontrar endereço por CEP.
     *
     * @param  string $zipcode
     *
     * @return array
     */
    public function find($zipcode)
    {
        $this->setZipCode($zipcode)
            ->buildXMLBody()
            ->sendWebServiceRequest()
            ->parseXMLFromResponse();

        if ($this->hasErrorMessage()) {
            return $this->fetchErrorMessage();
        }

        return $this->fetchZipCodeAddress();
    }

    /**
     * Seta o CEP informado.
     *
     * @param string $zipcode
     *
     * @return self
     */
    protected function setZipCode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Monta o corpo da requisição em XML.
     *
     * @return self
     */
    protected function buildXMLBody()
    {
        $zipcode = preg_replace('/[^0-9]/', null, $this->zipcode);
        $this->body = trim('
            <?xml version="1.0"?>
            <soapenv:Envelope
                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                xmlns:cli="http://cliente.bean.master.sigep.bsb.correios.com.br/">
                <soapenv:Header/>
                <soapenv:Body>
                    <cli:consultaCEP>
                        <cep>'.$zipcode.'</cep>
                    </cli:consultaCEP>
                </soapenv:Body>
            </soapenv:Envelope>
        ');

        return $this;
    }

    /**
     * Envia uma requisição para o webservice dos Correios
     * e salva a resposta para uso posterior.
     *
     * @return self
     */
    protected function sendWebServiceRequest()
    {
        $this->response = $this->http->post(WebService::SIGEP, [
            'http_errors' => false,
            'body' => $this->body,
            'headers' => [
                'Content-Type' => 'application/xml; charset=utf-8',
                'cache-control' => 'no-cache',
            ],
        ]);

        return $this;
    }

    /**
     * Formata o XML do corpo da resposta.
     *
     * @return self
     */
    protected function parseXMLFromResponse()
    {
        $xml = $this->response->getBody()->getContents();
        $parse = simplexml_load_string(str_replace([
            'soap:', 'ns2:',
        ], null, $xml));

        $this->parsedXML = json_decode(json_encode($parse->Body), true);

        return $this;
    }

    /**
     * Verifica se existe alguma mensagem de
     * erro no XML retornado da requisição.
     *
     * @return bool
     */
    protected function hasErrorMessage()
    {
        return array_key_exists('Fault', $this->parsedXML);
    }

    /**
     * Recupera mensagem de erro do XML formatada.
     *
     * @return array
     */
    protected function fetchErrorMessage()
    {
        return [
            'error' => $this->messages($this->parsedXML['Fault']['faultstring']),
        ];
    }

    /**
     * Mensagens de erro mais legíveis.
     *
     * @param  string $faultString
     *
     * @return string
     */
    protected function messages($faultString)
    {
        return [
            'CEP INVÁLIDO' => 'CEP não encontrado',
        ][$faultString];
    }

    /**
     * Retorna complemento de um endereço.
     *
     * @param  array  $address
     * @return array
     */
    protected function getComplement(array $address)
    {
        $complement = [];

        if (array_key_exists('complemento', $address)) {
            $complement[] = $address['complemento'];
        }

        if (array_key_exists('complemento2', $address)) {
            $complement[] = $address['complemento2'];
        }

        return $complement;
    }

    /**
     * Recupera endereço do XML de resposta.
     *
     * @return array
     */
    protected function fetchZipCodeAddress()
    {
        $address = $this->parsedXML['consultaCEPResponse']['return'];
        $zipcode = preg_replace('/^([0-9]{5})([0-9]{3})$/', '${1}-${2}', $address['cep']);
        $complement = $this->getComplement($address);

        return [
            'zipcode' => $zipcode,
            'street' => $address['end'],
            'complement' => $complement,
            'district' => $address['bairro'],
            'city' => $address['cidade'],
            'uf' => $address['uf'],
        ];
    }
}
