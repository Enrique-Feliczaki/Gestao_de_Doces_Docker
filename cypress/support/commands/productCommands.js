
Cypress.Commands.add('selectAvailableProductCategory', () => {
  cy.get('[data-cy="categoria-produto"]')
    .find('option')
    .then(($options) => {
      const available = [...$options].find(
        (option) => option.value !== '' && !option.disabled
      );

      expect(available, 'categoria disponível').to.exist;

      cy.get('[data-cy="categoria-produto"]').select(available.value);
    });
});

Cypress.Commands.add('fillProductForm', (product) => {
  cy.get('[data-cy="nome-produto"]')
    .clear()
    .type(product.name);

  cy.selectAvailableProductCategory();

  cy.get('[data-cy="preco-produto"]')
    .clear()
    .type(String(product.price));

  cy.get('[data-cy="estoque-produto"]')
    .clear()
    .type(String(product.stock_quantity));

  cy.get('[data-cy="estoque-minimo-produto"]')
    .clear()
    .type(String(product.minimum_stock ?? 0));
});

Cypress.Commands.add('submitProductForm', () => {
  cy.get('[data-cy="salvar-produto"]').click();
});
