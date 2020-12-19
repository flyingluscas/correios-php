<?php

namespace FlyingLuscas\Correios\Services;

use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class CalculateFreightTest extends TestCase
{
    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Mock payload.
     *
     * @var string
     */
    protected $responseMockForInvalidService;

    /**
     * Mock payload.
     *
     * @var string
     */
    protected $responseMockForSedex;

    /**
     * Mock payload.
     *
     * @var string
     */
    protected $responseMockForPAC;

    /**
     * Mock handler.
     *
     * @var \GuzzleHttp\Handler\MockHandler
     */
    protected $mock;

    public function setUp()
    {
        parent::setUp();

        $this->responseMockForInvalidService = '<?xml version="1.0" encoding="utf-8"?>
        <cResultado xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
          <Servicos>
            <cServico>
              <Codigo>99999</Codigo>
              <Valor>0,00</Valor>
              <PrazoEntrega>0</PrazoEntrega>
              <ValorMaoPropria>0,00</ValorMaoPropria>
              <ValorAvisoRecebimento>0,00</ValorAvisoRecebimento>
              <ValorValorDeclarado>0,00</ValorValorDeclarado>
              <EntregaDomiciliar />
              <EntregaSabado />
              <Erro>-888</Erro>
              <MsgErro>Para este serviço só está disponível o cálculo do PRAZO.</MsgErro>
              <ValorSemAdicionais>0,00</ValorSemAdicionais>
              <obsFim />
            </cServico>
          </Servicos>
        </cResultado>';

        $this->responseMockForSedex = '<?xml version="1.0" encoding="utf-8"?>
        <cResultado xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
          <Servicos>
            <cServico>
              <Codigo>4014</Codigo>
              <Valor>55,60</Valor>
              <PrazoEntrega>3</PrazoEntrega>
              <ValorMaoPropria>0,00</ValorMaoPropria>
              <ValorAvisoRecebimento>0,00</ValorAvisoRecebimento>
              <ValorValorDeclarado>0,00</ValorValorDeclarado>
              <EntregaDomiciliar>S</EntregaDomiciliar>
              <EntregaSabado>S</EntregaSabado>
              <Erro>0</Erro>
              <MsgErro />
              <ValorSemAdicionais>55,60</ValorSemAdicionais>
              <obsFim />
            </cServico>
          </Servicos>
        </cResultado>';

        $this->responseMockForPAC = '<?xml version="1.0" encoding="utf-8"?>
        <cResultado xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
          <Servicos>
            <cServico>
              <Codigo>4510</Codigo>
              <Valor>55,60</Valor>
              <PrazoEntrega>3</PrazoEntrega>
              <ValorMaoPropria>0,00</ValorMaoPropria>
              <ValorAvisoRecebimento>0,00</ValorAvisoRecebimento>
              <ValorValorDeclarado>0,00</ValorValorDeclarado>
              <EntregaDomiciliar>S</EntregaDomiciliar>
              <EntregaSabado>S</EntregaSabado>
              <Erro>0</Erro>
              <MsgErro />
              <ValorSemAdicionais>55,60</ValorSemAdicionais>
              <obsFim />
            </cServico>
          </Servicos>
        </cResultado>';

        $this->mock = new MockHandler([]);

        $handlerStack = HandlerStack::create($this->mock);

        $this->http = new HttpClient([
            'handler' => $handlerStack,
        ]);
    }

    public function testInvalidServiceError()
    {
        $this->mock->reset();
        $this->mock->append(new Response(200, [], $this->responseMockForInvalidService));

        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services('99999')
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => null,
                'code' => '99999',
                'price' => 0.0,
                'deadline' => 0,
                'error' => [
                    'code' => '-888',
                    'message' => 'Para este serviço só está disponível o cálculo do PRAZO.',
                ],
                'delivery_in_house' => false,
                'delivery_saturday' => false,
                'delivery_alert_price' => 0.0,
                'own_hands_price' => 0.0,
                'declared_amount_price' => 0.0,
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }

    public function testWithSingleService()
    {
        $this->mock->reset();
        $this->mock->append(new Response(200, [], $this->responseMockForSedex));

        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services(Service::SEDEX)
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => 'Sedex',
                'code' => Service::SEDEX,
                'price' => 55.6,
                'deadline' => 3,
                'error' => [],
                'delivery_in_house' => true,
                'delivery_saturday' => true,
                'delivery_alert_price' => 0.0,
                'own_hands_price' => 0.0,
                'declared_amount_price' => 0.0,
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }

    public function testWithMultipleServices()
    {
        $this->mock->reset();
        $this->mock->append(new Response(200, [], $this->responseMockForSedex));
        $this->mock->append(new Response(200, [], $this->responseMockForPAC));

        $freight = new Freight($this->http);

        $freight
            ->origin('01001-000')
            ->destination('87047-230')
            ->services(Service::SEDEX, Service::PAC)
            ->item(16, 16, 16, .3, 1);

        $expected = [
            [
                'name' => 'Sedex',
                'code' => Service::SEDEX,
                'price' => 55.6,
                'deadline' => 3,
                'error' => [],
                'delivery_in_house' => true,
                'delivery_saturday' => true,
                'delivery_alert_price' => 0.0,
                'own_hands_price' => 0.0,
                'declared_amount_price' => 0.0,
            ],
            [
                'name' => 'PAC',
                'code' => Service::PAC,
                'price' => 55.6,
                'deadline' => 3,
                'error' => [],
                'delivery_in_house' => true,
                'delivery_saturday' => false,
                'delivery_alert_price' => 0.0,
                'own_hands_price' => 0.0,
                'declared_amount_price' => 0.0,
            ],
        ];

        $this->assertEquals($expected, $freight->calculate());
    }
}
