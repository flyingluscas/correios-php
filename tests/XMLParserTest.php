<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Support\XMLParser;
use FlyingLuscas\Correios\Exceptions\InvalidXMLStringException;

class XMLParserTest extends TestCase
{
    use XMLParser;

    /**
     * @test
     * @dataProvider provideValidXMLStringToJson
     */
    public function testCanConvertXmlToJson($string, $expected)
    {
        $this->assertEquals($expected, $this->convertXMLToJson($string));
    }

    /**
     * @test
     * @dataProvider provideValidXMLStringToArray
     */
    public function testCanConvertXmlToArray($string, $expected)
    {
        $this->assertEquals($expected, $this->convertXMLToArray($string));
    }

    /**
     * @test
     */
    public function testThrowExceptionWithInvalidXMLString()
    {
        try {
            $this->convertXMLToJson('');
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidXMLStringException::class, $e);
        }
    }

    public function provideValidXMLStringToArray()
    {
        return [
            ['<root_element><element>test</element></root_element>', ['element' => "test"]]
        ];
    }

    public function provideValidXMLStringToJson()
    {
        return [
            ['<root_element><element>test</element></root_element>', json_encode(['element' => "test"])]
        ];
    }
}
