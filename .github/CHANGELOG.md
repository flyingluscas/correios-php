# Changelog

Todas as mudanças importantes em `correios-php` serão documentadas neste arquivo.

Atualizações devem seguir os princípios de [Keep a CHANGELOG](http://keepachangelog.com/).

## v2.4.0 - 2020-11-01

### Changed
- Atualização do `guzzlehttp/guzzle` para a versão `7.2`.

## v2.3.4 - 2019-10-13

### Changed
- Códigos dos serviços deixou de ter `0` na frente com a nova interface do Correios.
- Mensagem de erro quando um código de serviço inválido é informado.

### Fixed
- Cálculo para múltiplos serviços (Sedex, PAC...) que deixou de funcionar com a nova interface do Correios.

## v2.3.3 - 2018-12-26

### Fixed
- Corrigido o [erro disparado](https://github.com/flyingluscas/correios-php/issues/17) quando o campo "complemento" não está presente nas buscas de endereços por CEP.

## v2.3.2 - 2017-12-28

### Added
- Novos códigos de contrato do Correios - **[@lucascolette](https://github.com/lucascolette)**

## v2.2.2 - 2017-05-05

### Fixed
- **Sedex** e **PAC** atualizados de acordo com a atualização dos Correios no dia 05/05/2017 - **[@julianobailao](https://github.com/julianobailao)**
- Visibilidade do método **fetchZipCodeAddress** alterado para **protected** - **[@flyingluscas](https://github.com/flyingluscas)**

## v2.2.1 - 2017-04-26

### Fixed
- Implementado os métodos restantes na interface de frete.

## v2.2.0 - 2017-04-16

### Added
- Método `credentials` para informar código administrativo e senha dos Correios ao calcular frete.
- Método `package` para informar o tipo de embalagem (pacote, caixa, envelope e etc) ao calcular frete.
- Método `useOwnHand` para informar se deve ou não se usado o serviço adicional mão própria ao calcular frete.
- Método `declaredValue` para informar se deve ou não ser usado o serviço valor declarado ao calcular frete.

## v2.1.0 - 2017-04-09

### Added
- Busca de endereços via CEP

## v2.0.0 - 2017-04-05

### Changed
- Nova API implementada, tornando o uso do package mais simples e fluído.

## v1.1.1 - 2016-11-23

### Changed
- Estrutura do array de resposta quando calculando o frete foi alterada.

## v0.1.1 - 2016-11-21

### Fixed
- Laravel Collection removida resolvendo problemas de compatibilidade.

## v0.1.0 - 2016-11-15

### Added
- Cálculo de frete
