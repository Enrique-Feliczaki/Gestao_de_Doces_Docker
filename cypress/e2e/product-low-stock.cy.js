
describe('Alerta de estoque baixo', () => {
  const identificador = Date.now();
  const nomeEstoqueBaixo = `Produto Estoque Baixo ${identificador}`;
  const nomeEstoqueNormal = `Produto Estoque Normal ${identificador}`;

  function cadastrarProduto(nome, estoque, estoqueMinimo) {
    cy.visit('/products/create');

    cy.get('[data-cy="nome-produto"]').type(nome);

    cy.get('[data-cy="categoria-produto"]')
      .find('option')
      .then(($options) => {
        const categoria = [...$options].find(
          (option) => option.value !== '' && !option.disabled
        );

        expect(categoria, 'categoria disponível').to.exist;

        cy.get('[data-cy="categoria-produto"]')
          .select(categoria.value);
      });

    cy.get('[data-cy="preco-produto"]').clear().type('10.00');
    cy.get('[data-cy="estoque-produto"]').clear().type(String(estoque));
    cy.get('[data-cy="estoque-minimo-produto"]').clear().type(String(estoqueMinimo));

    cy.get('[data-cy="salvar-produto"]').click();

    cy.location('pathname').should('eq', '/products');
  }

  it('deve exibir o alerta para estoque baixo e não exibi-lo para estoque normal', () => {
    // Cadastra produto com estoque abaixo do mínimo
    cadastrarProduto(nomeEstoqueBaixo, 2, 5);

    cy.get('[data-cy="tabela-produtos"]').should('exist');

    cy.contains('tbody tr', nomeEstoqueBaixo)
      .should('exist')
      .within(() => {
        cy.get('[data-cy="alerta-estoque-baixo"]')
          .should('be.visible')
          .and('contain.text', 'Estoque baixo');
      });

    // Cadastra produto com estoque acima do mínimo
    cadastrarProduto(nomeEstoqueNormal, 10, 5);

    cy.contains('tbody tr', nomeEstoqueNormal)
      .should('exist')
      .within(() => {
        cy.get('[data-cy="alerta-estoque-baixo"]')
          .should('not.exist');
      });

    // Limpa os produtos criados pelo teste
    cy.on('window:confirm', () => true);

    cy.contains('tbody tr', nomeEstoqueBaixo)
      .find('[data-cy="excluir-produto"]')
      .click();

    cy.contains('tbody tr', nomeEstoqueNormal)
      .find('[data-cy="excluir-produto"]')
      .click();
  });
});
