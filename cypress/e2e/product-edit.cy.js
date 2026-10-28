
describe('Edição de produto', () => {
  beforeEach(() => {
    cy.visit('/products');
  });

  it('deve editar o preço de um produto existente', () => {
    // Abre a edição do primeiro produto listado.
    cy.get('[data-cy="editar-produto"]')
      .first()
      .click();

    cy.url().should('include', '/products/');

    // Altera o preço.
    cy.get('[data-cy="preco-produto"]')
      .should('be.visible')
      .clear()
      .type('25.90');

    // Salva as alterações.
    cy.get('[data-cy="salvar-produto"]').click();

    // Confirma o retorno à listagem.
    cy.location('pathname').should('eq', '/products');

    // Confirma a mensagem de sucesso.
    cy.get('.mensagem')
      .should('be.visible')
      .and('contain.text', 'sucesso');
  });
});
