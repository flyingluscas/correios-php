<?php

namespace FlyingLuscas\Correios;

abstract class Format
{
    /**
     * Caixa ou pacote.
     */
    const BOX = 1;

    /**
     * Rolo ou prisma.
     */
    const ROLL = 2;

    /**
     * Envelope.
     */
    const ENVELOPE = 3;
}
