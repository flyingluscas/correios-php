<?php

namespace FlyingLuscas\Correios;

abstract class PackageType
{
    /**
     * Formatos caixa ou pacote.
     */
    const BOX = 1;

    /**
     * Formatos rolo ou prisma.
     */
    const ROLL = 2;

    /**
     * Formato envelope.
     */
    const ENVELOPE = 3;
}
