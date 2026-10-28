
class ProductFormPage {
  selectors = {
    name: '[data-cy="nome-produto"]',
    category: '[data-cy="categoria-produto"]',
    price: '[data-cy="preco-produto"]',
    stock: '[data-cy="estoque-produto"]',
    minimumStock: '[data-cy="estoque-minimo-produto"]',
    submit: '[data-cy="salvar-produto"]',
  };

  visitCreate() {
    cy.visit('/products/create');
  }

  fill(product) {
    cy.get(this.selectors.name).clear().type(product.name);

    cy.get(this.selectors.category)
      .find('option')
      .then(($options) => {
        const available = [...$options].find(
          (option) => option.value !== '' && !option.disabled
        );

        expect(available, 'categoria disponível').to.exist;

        const category = [...$options].some(
          (option) =>
            option.value === product.category &&
            !option.disabled
        )
          ? product.category
          : available.value;

        cy.get(this.selectors.category).select(category);
      });

    cy.get(this.selectors.price)
      .clear()
      .type(String(product.price));

    cy.get(this.selectors.stock)
      .clear()
      .type(String(product.stock_quantity));

    if (product.minimum_stock !== undefined) {
      cy.get(this.selectors.minimumStock)
        .clear()
        .type(String(product.minimum_stock));
    }
  }

  fillInvalid(product) {
    cy.get(this.selectors.name)
      .clear()
      .type(product.name);

    cy.get(this.selectors.price)
      .clear()
      .type(String(product.price));

    cy.get(this.selectors.stock)
      .clear()
      .type(String(product.stock_quantity));

    if (product.minimum_stock !== undefined) {
      cy.get(this.selectors.minimumStock)
        .clear()
        .type(String(product.minimum_stock));
    }

    // Mantém a categoria vazia para testar a validação do formulário.
  }

  getCategory() {
    return cy.get(this.selectors.category);
  }

  submit() {
    cy.get(this.selectors.submit).click();
  }
}

export default ProductFormPage;
