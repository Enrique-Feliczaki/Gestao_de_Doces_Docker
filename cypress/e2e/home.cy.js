
describe('Página inicial do Doces Gestão', () => {
  it('deve carregar a página inicial com sucesso', () => {
    cy.visit('/');

    cy.get('body').should('be.visible');
  });
});
