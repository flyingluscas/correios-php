<?php

namespace FlyingLuscas\Correios\Contracts;

interface TransformerInterface
{
    /**
     * Transform resource.
     *
     * @param  mixed $resource
     *
     * @return mixed
     */
    public function transform($resource);
}
