
describe('CRUD completo de produtos', () => {
  const nomeOriginal = `Produto CRUD ${Date.now()}`;
  const nomeEditado = `Produto Editado ${Date.now()}`;

  beforeEach(() => {
    cy.visit('/products/create');
  });

  it('deve cadastrar, editar e excluir um produto', () => {
    // 1. CADASTRAR
    cy.get('[data-cy="nome-produto"]')
      .type(nomeOriginal);

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

    // Valida o cadastro
    cy.location('pathname').should('eq', '/products');
    cy.contains('tr', nomeOriginal).should('be.visible');

    // 2. EDITAR
    cy.contains('tr', nomeOriginal)
      .find('[data-cy="editar-produto"]')
      .click();

    cy.get('[data-cy="nome-produto"]')
      .clear()
      .type(nomeEditado);

    cy.get('[data-cy="preco-produto"]')
      .clear()
      .type('25.90');

    cy.get('[data-cy="salvar-produto"]').click();

    // Valida a edição
    cy.location('pathname').should('eq', '/products');
    cy.contains('tr', nomeEditado).should('be.visible');
    cy.contains('tr', nomeOriginal).should('not.exist');

    // 3. EXCLUIR
    cy.on('window:confirm', () => true);

    cy.contains('tr', nomeEditado)
      .find('[data-cy="excluir-produto"]')
      .click();

    // Valida a exclusão
    cy.location('pathname').should('eq', '/products');
    cy.contains('tr', nomeEditado).should('not.exist');
  });
});
