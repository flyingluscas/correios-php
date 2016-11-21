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
    public function it_can_transform_services_xml($sample, $expected)
    {
        $xml = file_get_contents($sample);
        $transformer = new FreightServiceTransformer;

        $this->assertEquals($expected, $transformer->transform($xml));
    }
}
