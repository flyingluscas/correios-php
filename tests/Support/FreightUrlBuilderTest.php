<?php

namespace FlyingLuscas\Correios\Support;

use FlyingLuscas\Correios\Domains\Correios\Cart\Cart;
use FlyingLuscas\Correios\Domains\Correios\Freight\Freight;
use FlyingLuscas\Correios\Domains\Correios\Freight\Url;
use Mockery;
use FlyingLuscas\Correios\TestCase;

class FreightUrlBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_build_url()
    {
        $cart = $this->getMockForCart();
        $freight = $this->getMockForFreight($cart);

        $builder = new FreightUrlBuilder($freight);

        $params = [
            'nCdEmpresa' => '',
            'sDsSenha' => '',
            'nCdServico' => '1,2',
            'sCepOrigem' => '00000000',
            'sCepDestino' => '99999999',
            'nCdFormato' => 1,
            'nVlComprimento' => 1,
            'nVlAltura' => 1,
            'nVlLargura' => 1,
            'nVlDiametro' => 0,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => 0,
            'sCdAvisoRecebimento' => 'N',
            'nVlPeso' => 1,
        ];

        $url = sprintf('%s?%s', Url::PRICE_DEADLINE, http_build_query($params));

        $this->assertEquals($url, $builder->makeUrl());
    }

    /**
     * Get mock for Freight.
     *
     * @param  \FlyingLuscas\Correios\Domains\Correios\Cart\Cart $cart
     *
     * @return \FlyingLuscas\Correios\Domains\Correios\Freight\Freight
     */
    private function getMockForFreight(Cart $cart)
    {
        $args = func_get_args();

        $mock = Mockery::mock(Freight::class, function ($mock) use ($args) {
            $mock->shouldReceive('getCompanyCode')->andReturn('');
            $mock->shouldReceive('getCompanyPassword')->andReturn('');
            $mock->shouldReceive('getServices')->andReturn([1, 2]);
            $mock->shouldReceive('getOriginZipCode')->andReturn('00000000');
            $mock->shouldReceive('getDestinyZipCode')->andReturn('99999999');
            $mock->shouldReceive('getFormat')->andReturn(1);
            $mock->shouldReceive('getOwnHand')->andReturn('N');
            $mock->shouldReceive('getDeclaredValue')->andReturn(0);
            $mock->shouldReceive('getNoticeOfReceipt')->andReturn('N');
        });

        $mock->cart = $cart;

        return $mock;
    }

    /**
     * Get mock for cart.
     *
     * @param  int    $width
     * @param  int    $height
     * @param  int    $length
     * @param  int    $weight
     * @param  int    $volume
     *
     * @return \FlyingLuscas\Correios\Domains\Correios\Cart\Cart
     */
    private function getMockForCart($width = 1, $height = 1, $length = 1, $weight = 1, $volume = 1)
    {
        $args = [
            $width, $height, $length, $weight, $volume,
        ];

        return Mockery::mock(Cart::class, function ($mock) use ($args) {
            $mock->shouldReceive('getMaxLength')->andReturn($args[0]);
            $mock->shouldReceive('getTotalHeight')->andReturn($args[1]);
            $mock->shouldReceive('getMaxWidth')->andReturn($args[2]);
            $mock->shouldReceive('getTotalVolume')->andReturn($args[3]);
            $mock->shouldReceive('getTotalWeight')->andReturn($args[4]);
        });
    }
}
