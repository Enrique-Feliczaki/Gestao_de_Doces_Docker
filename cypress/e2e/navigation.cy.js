describe('Navegação pelo menu', () => {
  it('deve acessar Produtos e validar a URL', () => {
    cy.visit('/');
    cy.contains('a', 'Produtos').click();
    cy.url().should('include', '/products');
  });
});
