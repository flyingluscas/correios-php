<?php

namespace FlyingLuscas\Correios;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Get Guzzle HTTP client mock.
     *
     * @param  \GuzzleHttp\Psr7\Response|array  $response
     *
     * @return \GuzzleHttp\Client
     */
    protected function getMockForGuzzleClient($response)
    {
        if (! is_array($response)) {
            $response = [$response];
        }

        $mock = new MockHandler($response);

        return new Client([
            'handler' => HandlerStack::create($mock),
        ]);
    }

    /**
     * Make stub items.
     *
     * @param  int   $amount
     * @param  array $data
     *
     * @return array
     */
    protected function items($amount, array $data = [])
    {
        for ($i = 0; $i < $amount; $i++) {
            $results[] = array_merge([
                'width' => 10,
                'height' => 10,
                'length' => 10,
                'weight' => 10,
                'quantity' => 1,
            ], $data);
        }

        return ($amount > 1) ? $results : $results[0];
    }

    /**
     * Provide services samples of XML.
     *
     * @return array
     */
    public function provideServicesXMLSamples()
    {
        return [
            [
                __DIR__.'/Samples/SingleService.xml',
                [
                    [
                        'code' => Service::SEDEX,
                        'value' => 16.10,
                        'deadline' => 1,
                        'own_hand_value' => 0.0,
                        'notice_receipt_value' => 0.0,
                        'declared_value' => 0.0,
                        'home_delivery' => true,
                        'saturday_delivery' => false,
                        'error' => [
                            'code' => 0,
                            'message' => null,
                        ],
                    ]
                ],
            ],
            [
                __DIR__.'/Samples/ManyServices.xml',
                [
                    [
                        'code' => Service::SEDEX,
                        'value' => 16.10,
                        'deadline' => 1,
                        'own_hand_value' => 0.0,
                        'notice_receipt_value' => 0.0,
                        'declared_value' => 0.0,
                        'home_delivery' => true,
                        'saturday_delivery' => false,
                        'error' => [
                            'code' => 0,
                            'message' => null,
                        ],
                    ],
                    [
                        'code' => Service::PAC,
                        'value' => 16.10,
                        'deadline' => 5,
                        'own_hand_value' => 0.0,
                        'notice_receipt_value' => 0.0,
                        'declared_value' => 0.0,
                        'home_delivery' => true,
                        'saturday_delivery' => false,
                        'error' => [
                            'code' => 0,
                            'message' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
