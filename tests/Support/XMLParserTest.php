<?php

namespace FlyingLuscas\Correios\Support;

use FlyingLuscas\Correios\TestCase;
use FlyingLuscas\Correios\Exceptions\InvalidXMLStringException;

class XMLParserTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideValidXMLStringToJson
     */
    public function it_can_convert_xml_to_json($string, $expected)
    {
        $mock = $this->getMockForTrait(XMLParser::class);

        $this->assertEquals($expected, $mock->convertXMLToJson($string));
    }

    /**
     * @test
     * @dataProvider provideValidXMLStringToArray
     */
    public function it_can_convert_xml_to_array($string, $expected)
    {
        $mock = $this->getMockForTrait(XMLParser::class);

        $this->assertEquals($expected, $mock->convertXMLToArray($string));
    }

    /**
     * @test
     */
    public function it_throws_exception_when_get_invalid_xml_string()
    {
        $this->setExpectedException(InvalidXMLStringException::class);

        $this->getMockForTrait(XMLParser::class)->convertXMLToJson('');
    }

    public function provideValidXMLStringToArray()
    {
        return [
            ['<root_element><element>test</element></root_element>', ['element' => 'test']]
        ];
    }

    public function provideValidXMLStringToJson()
    {
        return [
            ['<root_element><element>test</element></root_element>', json_encode(['element' => 'test'])]
        ];
    }
}
