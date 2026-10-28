
import ProductFormPage from '../support/pages/ProductFormPage';

describe('Cadastro de produto', () => {
  const form = new ProductFormPage();

  beforeEach(() => {
    cy.visit('/products/create');
  });

  it('deve cadastrar um produto com sucesso', () => {
    cy.fixture('produto.json').then((produto) => {
      const produtoTeste = {
        ...produto,
        name: `${produto.name} ${Date.now()}`,
      };

      cy.fillProductForm(produtoTeste);
        cy.submitProductForm();

      cy.location('pathname').should('eq', '/products');

      cy.get('.mensagem')
        .should('be.visible')
        .and('contain.text', 'sucesso');

      cy.contains('tbody tr', produtoTeste.name).should('exist');
    });
  });
});
