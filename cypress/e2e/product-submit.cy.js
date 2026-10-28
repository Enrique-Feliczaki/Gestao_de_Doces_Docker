
describe('Cadastro de produto', () => {
  beforeEach(() => {
    cy.visit('/products/create');
  });

  it('deve cadastrar um produto com sucesso', () => {
    cy.get('[data-cy="nome-produto"]')
      .type('Produto Teste Cypress');

    // Seleciona a primeira categoria disponível.
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

    cy.get('[data-cy="preco-produto"]')
      .clear()
      .type('15.50');

    cy.get('[data-cy="estoque-produto"]')
      .clear()
      .type('20');

    cy.get('button[type="submit"]').click();

    // Confirma o redirecionamento para a listagem.
    cy.location('pathname').should('eq', '/products');

    // Confirma a mensagem de sucesso.
    cy.get('.mensagem')
      .should('be.visible')
      .and('contain.text', 'sucesso');
  });
});
