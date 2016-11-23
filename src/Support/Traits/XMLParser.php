<?php

namespace FlyingLuscas\Correios\Support\Traits;

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
    public function toArray($xml)
    {
        return json_decode($this->toJson($xml), true);
    }

    /**
     * Convert XML in to a JSON string.
     *
     * @param  string $xml
     *
     * @return string
     */
    public function toJson($xml)
    {
        if (! $this->isValidXML($xml)) {
            throw new InvalidXMLStringException;
        }

        return json_encode(simplexml_load_string($xml));
    }

    /**
     * Check if a string contains a valid XML content.
     *
     * @param  string $xml
     *
     * @return bool
     */
    public function isValidXML($xml)
    {
        if (! trim($xml)) {
            return false;
        }

        libxml_use_internal_errors(true);

        simplexml_load_string($xml);
        $errors = libxml_get_errors();

        libxml_clear_errors();

        return count($errors) == 0;
    }
}
