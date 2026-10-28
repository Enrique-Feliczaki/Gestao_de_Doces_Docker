
import ProductFormPage from '../pages/ProductFormPage';
import ProductListPage from '../pages/ProductListPage';

Cypress.Commands.add('fillProductForm', (product) => {
  const form = new ProductFormPage();
  form.fill(product);
});

Cypress.Commands.add('submitProductForm', () => {
  const form = new ProductFormPage();
  form.submit();
});

Cypress.Commands.add('visitProductList', () => {
  const list = new ProductListPage();
  list.visit();
});
