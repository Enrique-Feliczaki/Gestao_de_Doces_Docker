
import ProductFormPage from '../support/pages/ProductFormPage';
import ProductListPage from '../support/pages/ProductListPage';

describe('Alerta de estoque baixo', () => {
  const form = new ProductFormPage();
  const list = new ProductListPage();

  it('deve exibir o alerta para estoque baixo e não exibi-lo para estoque normal', () => {
    cy.fixture('produto.json').then((produto) => {
      const identificador = Date.now();

      const produtoEstoqueBaixo = {
        ...produto,
        name: `Produto Estoque Baixo ${identificador}`,
        stock_quantity: 2,
        minimum_stock: 5,
      };

      const produtoEstoqueNormal = {
        ...produto,
        name: `Produto Estoque Normal ${identificador}`,
        stock_quantity: 10,
        minimum_stock: 5,
      };

      function cadastrarProduto(dados) {
        form.visitCreate();
        cy.fillProductForm(dados);
        cy.submitProductForm();

        cy.location('pathname').should('eq', '/products');
      }

      cadastrarProduto(produtoEstoqueBaixo);

      cy.get(list.selectors.table).should('exist');

      list.rowByName(produtoEstoqueBaixo.name)
        .should('exist')
        .within(() => {
          cy.get(list.selectors.lowStockAlert)
            .should('be.visible')
            .and('contain.text', 'Estoque baixo');
        });

      cadastrarProduto(produtoEstoqueNormal);

      list.rowByName(produtoEstoqueNormal.name)
        .should('exist')
        .within(() => {
          cy.get(list.selectors.lowStockAlert).should('not.exist');
        });

      cy.on('window:confirm', () => true);

      list.deleteProduct(produtoEstoqueBaixo.name);
      list.rowByName(produtoEstoqueBaixo.name).should('not.exist');

      list.deleteProduct(produtoEstoqueNormal.name);
      list.rowByName(produtoEstoqueNormal.name).should('not.exist');
    });
  });
});
