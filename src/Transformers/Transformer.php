<?php

namespace FlyingLuscas\Correios\Transformers;

use FlyingLuscas\Correios\Contracts\TransformerInterface;

trait Transformer
{
    /**
     * Transform a resource.
     *
     * @param  mixed                $resource
     * @param  TransformerInterface $transformer
     *
     * @return mixed
     */
    protected function transform($resource, TransformerInterface $transformer)
    {
        return $transformer->transform($resource);
    }
}
