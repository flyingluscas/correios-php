<?php

namespace FlyingLuscas\Correios\Utils;

use FlyingLuscas\Correios\Exceptions\InvalidXmlStringException;

trait XmlParser
{
    /**
     * Convert XML in to array.
     *
     * @param  string $xml
     *
     * @return array
     */
    public function convertXMLToArray($xml)
    {
        return json_decode($this->convertXMLToJson($xml), true);
    }

    /**
     * Convert XML in to array.
     *
     * @param  string $xml
     *
     * @return array
     */
    public function convertXMLToJson($xml)
    {
        if (!$this->isValidXml($xml)) {
            throw new InvalidXmlStringException;
        }

        return json_encode(simplexml_load_string($xml, "SimpleXMLElement"));
    }

    /**
     * Check if a string contains a valid xml content
     *
     * @param  string $xml
     *
     * @return boolean
     */
    public function isValidXml($xml)
    {
        if (trim($xml) == '') {
            return false;
        }

        libxml_use_internal_errors(true);
        $content = simplexml_load_string($xml);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return (count($errors) == 0);
    }
}
