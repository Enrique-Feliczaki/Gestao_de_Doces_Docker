
import ProductFormPage from '../support/pages/ProductFormPage';

describe('Formulário de novo produto', () => {
  const form = new ProductFormPage();

  it('deve abrir o formulário e exibir os campos obrigatórios', () => {
    cy.visit('/products');
    cy.contains('a', 'Novo produto').click();

    cy.url().should('include', '/products/create');

    cy.get(form.selectors.name).should('be.visible');

    cy.get(form.selectors.category)
      .should('be.visible')
      .and('have.prop', 'tagName', 'SELECT');

    cy.get(form.selectors.price).should('be.visible');
    cy.get(form.selectors.stock).should('be.visible');
    cy.get(form.selectors.minimumStock).should('be.visible');
  });
});
