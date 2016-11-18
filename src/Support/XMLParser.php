<?php

namespace FlyingLuscas\Correios\Support;

use FlyingLuscas\Correios\Exceptions\InvalidXMLStringException;

trait XMLParser
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
     * Convert XML in to a JSON string.
     *
     * @param  string $xml
     *
     * @return string
     */
    public function convertXMLToJson($xml)
    {
        if (!$this->isValidXml($xml)) {
            throw new InvalidXMLStringException;
        }

        return json_encode(simplexml_load_string($xml, "SimpleXMLElement"));
    }

    /**
     * Check if a string contains a valid XML content.
     *
     * @param  string $xml
     *
     * @return bool
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
