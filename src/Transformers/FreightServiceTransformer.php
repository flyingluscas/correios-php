<?php

namespace FlyingLuscas\Correios\Transformers;

use FlyingLuscas\Correios\Support\Traits\XMLParser;
use FlyingLuscas\Correios\Contracts\TransformerInterface;

class FreightServiceTransformer implements TransformerInterface
{
    use XMLParser;

    /**
     * Transform one or more freight services in to a readble array.
     *
     * @param  string $xml
     *
     * @return array
     */
    public function transform($xml)
    {
        $data = $this->convertXMLToArray($xml);

        if (array_key_exists('Codigo', $data['Servicos']['cServico'])) {
            return [$this->service($data['Servicos']['cServico'])];
        }

        foreach ($data['Servicos']['cServico'] as $service) {
            $results[] = $this->service($service);
        }

        return $results;
    }

    /**
     * Transform a single service.
     *
     * @param  array  $service
     *
     * @return array
     */
    protected function service(array $service)
    {
        return [
            'service' => intval($service['Codigo']),
            'value' => floatval(str_replace(',', '.', $service['Valor'])),
            'deadline' => intval($service['PrazoEntrega']),
            'own_hand_value' => floatval(str_replace(',', '.', $service['ValorMaoPropria'])),
            'notice_receipt_value' => floatval(str_replace(',', '.', $service['ValorAvisoRecebimento'])),
            'declared_value' => floatval(str_replace(',', '.', $service['ValorValorDeclarado'])),
            'home_delivery' => $service['EntregaDomiciliar'] == 'S',
            'saturday_delivery' => $service['EntregaSabado'] == 'S',
            'error' => [
                'code' => $service['Erro'],
                'message' => $service['MsgErro'] ?: null,
            ],
        ];
    }
}
