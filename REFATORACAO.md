
# Refatoração dos testes Cypress — Atividade 2

## Objetivo

Melhorar a organização, a reutilização e a estabilidade dos testes automatizados, mantendo a cobertura funcional existente.

## Problemas identificados e soluções

| Problema (smell) | Solução aplicada |
|---|---|
| Seletores repetidos nos testes | Centralização dos seletores em Page Objects |
| Preenchimento repetido do formulário de produtos | Criação do comando personalizado `fillProductForm` |
| Envio repetido do formulário | Criação do comando personalizado `submitProductForm` |
| Navegação repetida para a listagem | Criação do comando `visitProductList` |
| Dados de teste definidos diretamente nos cenários | Uso de fixtures JSON |
| Ausência de cenário com dados inválidos externos ao teste | Fixture `produto-invalido.json` e cenário de validação |
| Esperas fixas podem deixar os testes instáveis | Uso de asserções e retentativas automáticas do Cypress |

## Page Objects

- `ProductFormPage.js`: concentra os seletores e as ações do formulário de produtos.
- `ProductListPage.js`: concentra as ações e os seletores da listagem.

## Commands

Os comandos personalizados ficam em `cypress/support/commands/productCommands.js`:

- `fillProductForm(product)`: preenche o formulário.
- `submitProductForm()`: envia o formulário.
- `visitProductList()`: acessa a listagem de produtos.

## Fixtures

- `produto.json`: contém dados válidos para cadastro e outros cenários.
- `produto-invalido.json`: contém dados inválidos usados no teste de validação.

## Estabilidade e validação

Os testes da aplicação foram executados após as alterações. Os cenários de validação, cadastro e alerta de estoque passaram nas execuções realizadas.

A suíte deve ser executada três vezes consecutivas para verificar a estabilidade. Os testes de exemplo do Cypress devem ser avaliados separadamente dos testes da aplicação.
