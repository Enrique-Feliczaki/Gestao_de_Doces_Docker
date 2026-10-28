describe('Formulário de novo produto', () => {
  it('deve abrir o formulário e exibir os campos obrigatórios', () => {
    cy.visit('/products');

    cy.contains('a', 'Novo produto').click();

    cy.url().should('include', '/products/create');

    cy.get('#name').should('be.visible');

    cy.get('#category')
      .should('be.visible')
      .and('have.prop', 'tagName', 'SELECT');

    cy.get('#price').should('be.visible');
    cy.get('#stock_quantity').should('be.visible');
    cy.get('#minimum_stock').should('be.visible');
  });
});
