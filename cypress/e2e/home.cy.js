describe('Página inicial do Doces Gestão', () => {
  it('deve exibir o texto Doce Gestão', () => {
    cy.visit('/');
    cy.contains('Doce Gestão').should('be.visible');
  });
});
