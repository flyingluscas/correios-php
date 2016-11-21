<?php

namespace FlyingLuscas\Correios\Transformers;

use FlyingLuscas\Correios\Service;
use FlyingLuscas\Correios\TestCase;

class FreightServiceTransformerTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideServicesXMLSamples
     */
    public function it_can_transform_services_xml($file, $expected)
    {
        $file = sprintf('%s/../Samples/%s', __DIR__, $file);
        $xml = file_get_contents($file);
        $transformer = new FreightServiceTransformer;

        $this->assertEquals($expected, $transformer->transform($xml));
    }

    /**
     * Provide services sampels of XML.
     *
     * @return array
     */
    public function provideServicesXMLSamples()
    {
        return [
            [
                'SingleService.xml',
                [
                    [
                        'service' => Service::SEDEX,
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
                'ManyServices.xml',
                [
                    [
                        'service' => Service::SEDEX,
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
                        'service' => Service::PAC,
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
