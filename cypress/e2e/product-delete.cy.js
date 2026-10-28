
describe('Exclusão de produto', () => {
  const nomeProduto = `Produto Exclusao Cypress ${Date.now()}`;

  beforeEach(() => {
    cy.visit('/products/create');
  });

  it('deve cadastrar e excluir um produto de teste', () => {
    // Cadastra um produto exclusivo para este teste
    cy.get('[data-cy="nome-produto"]')
      .type(nomeProduto);

    cy.get('[data-cy="categoria-produto"]')
      .find('option')
      .then(($options) => {
        const categoria = [...$options].find(
          (option) => option.value !== '' && !option.disabled
        );

        expect(categoria, 'categoria disponível').to.exist;

        cy.get('[data-cy="categoria-produto"]')
          .select(categoria.value);
      });

    cy.get('[data-cy="preco-produto"]')
      .clear()
      .type('12.50');

    cy.get('[data-cy="estoque-produto"]')
      .clear()
      .type('5');

    cy.get('[data-cy="salvar-produto"]').click();

    // Confirma que o cadastro foi concluído
    cy.location('pathname').should('eq', '/products');

    cy.contains(nomeProduto).should('be.visible');

    // Aceita automaticamente a confirmação nativa do navegador,
    // caso a aplicação utilize window.confirm()
    cy.on('window:confirm', () => true);

    // Localiza a linha do produto de teste e o exclui
    cy.contains('tr', nomeProduto)
      .find('[data-cy="excluir-produto"]')
      .click();

    // Valida que o produto foi removido da listagem
    cy.location('pathname').should('eq', '/products');

    cy.contains(nomeProduto).should('not.exist');
  });
});
