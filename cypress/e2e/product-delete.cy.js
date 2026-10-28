import ProductFormPage from '../support/pages/ProductFormPage';
import ProductListPage from '../support/pages/ProductListPage';

describe('Exclusão de produto', () => {
  const form = new ProductFormPage();
  const list = new ProductListPage();

  it('deve cadastrar e excluir um produto de teste', () => {
    const nomeProduto = `Produto Exclusao Cypress ${Date.now()}`;

    cy.fixture('produto.json').then((produto) => {
      const produtoTeste = {
        ...produto,
        name: nomeProduto,
        price: '12.50',
        stock_quantity: 5,
        minimum_stock: 0,
      };

      form.visitCreate();
      form.fill(produtoTeste);
      form.submit();

      cy.location('pathname').should('eq', '/products');
      list.rowByName(nomeProduto).should('be.visible');

      // Intercepta e aceita a confirmação nativa do navegador.
      cy.on('window:confirm', (mensagem) => {
        expect(mensagem).to.be.a('string');
        return true;
      });

      list.deleteProduct(nomeProduto);

      cy.location('pathname').should('eq', '/products');
      list.rowByName(nomeProduto).should('not.exist');
    });
  });
});