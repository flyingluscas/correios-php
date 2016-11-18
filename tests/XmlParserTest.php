<?php

namespace FlyingLuscas\Correios;

use FlyingLuscas\Correios\Utils\XmlParser;
use FlyingLuscas\Correios\Exceptions\InvalidXmlStringException;

class XmlParserTest extends TestCase
{
    use XmlParser;

    /**
     * @test
     * @dataProvider provideValidXmlStringToJson
     */
    public function testCanConvertXmlToJson($string, $expected)
    {
        $this->assertEquals($expected, $this->convertXMLToJson($string));
    }

    /**
     * @test
     * @dataProvider provideValidXmlStringToArray
     */
    public function testCanConvertXmlToArray($string, $expected)
    {
        $this->assertEquals($expected, $this->convertXMLToArray($string));
    }

    /**
     * @test
     */
    public function testThrowExceptionWithInvalidXmlString()
    {
        try {
            $this->convertXMLToJson('');
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidXmlStringException::class, $e);
        }
    }

    public function provideValidXmlStringToArray()
    {
        return [
            ['<root_element><element>test</element></root_element>', ['element' => "test"]]
        ];
    }

    public function provideValidXmlStringToJson()
    {
        return [
            ['<root_element><element>test</element></root_element>', json_encode(['element' => "test"])]
        ];
    }
}
