<?php

namespace FlyingLuscas\Correios\Contracts;

interface FreightInterface
{
    /**
     * Payload da requisição para o webservice dos Correios.
     *
     * @param  string $service Serviço (Sedex, PAC...)
     *
     * @return array
     */
    public function payload($service);

    /**
     * CEP de origem.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function origin($zipCode);

    /**
     * CEP de destino.
     *
     * @param  string $zipCode
     *
     * @return self
     */
    public function destination($zipCode);

    /**
     * Serviços a serem calculados.
     *
     * @param  int ...$services
     *
     * @return self
     */
    public function services(...$services);

    /**
     * Código administrativo junto à ECT. O código está disponível no
     * corpo do contrato firmado com os Correios.
     *
     * Senha para acesso ao serviço, associada ao seu código administrativo,
     * a senha inicial corresponde aos 8 primeiros dígitos do CNPJ informado no contrato.
     *
     * @param  string $code
     * @param  string $password
     *
     * @return self
     */
    public function credentials($code, $password);

    /**
     * Formato da encomenda (Caixa, pacote, rolo, prisma ou envelope).
     *
     * @param  int $format
     *
     * @return self
     */
    public function package($format);

    /**
     * Indique se a encomenda será entregue com o serviço adicional mão própria.
     *
     * @param  bool $useOwnHand
     *
     * @return self
     */
    public function useOwnHand($useOwnHand);

    /**
     * Indique se a encomenda será entregue com o serviço adicional valor declarado,
     * deve ser apresentado o valor declarado desejado, em reais.
     *
     * @param  int|float $value
     *
     * @return self
     */
    public function declaredValue($value);

    /**
     * Dimensões, peso e quantidade do item.
     *
     * @param  int|float $width
     * @param  int|float $height
     * @param  int|float $length
     * @param  int|float $weight
     * @param  int       $quantity
     *
     * @return self
     */
    public function item($width, $height, $length, $weight, $quantity = 1);

    /**
     * Calcula preços e prazos junto ao Correios.
     *
     * @return array
     */
    public function calculate();
}
