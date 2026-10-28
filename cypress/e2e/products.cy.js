describe('Listagem de produtos', () => {
  beforeEach(() => {
    cy.visit('/products');
  });

  it('deve exibir a tabela com produtos e cabeçalhos principais', () => {
    cy.get('table').should('exist');
    cy.get('table tbody tr').should('have.length.at.least', 1);

    cy.contains('th', 'Produto').should('be.visible');
    cy.contains('th', 'Categoria').should('be.visible');
    cy.get('table thead th').eq(2).should('be.visible');
    cy.contains('th', 'Estoque').should('be.visible');
  });
});
