
class ProductListPage {
  selectors = {
    table: '[data-cy="tabela-produtos"]',
    edit: '[data-cy="editar-produto"]',
    delete: '[data-cy="excluir-produto"]',
    lowStockAlert: '[data-cy="alerta-estoque-baixo"]',
  };

  visit() {
    cy.visit('/products');
  }

  rowByName(name) {
    return cy.contains('tbody tr', name);
  }

  editProduct(name) {
    this.rowByName(name)
      .find(this.selectors.edit)
      .click();
  }

  deleteProduct(name) {
    this.rowByName(name)
      .find(this.selectors.delete)
      .click();
  }
}

export default ProductListPage;
