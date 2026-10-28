
describe('Validação de valores inválidos do produto', () => {
  beforeEach(() => {
    cy.visit('/products/create');
  });

  it('deve rejeitar preço negativo', () => {
    cy.get('[data-cy="preco-produto"]')
      .clear()
      .type('-10')
      .should('have.value', '-10')
      .and(($campo) => {
        expect($campo[0].validity.rangeUnderflow).to.equal(true);
      });
  });

  it('deve rejeitar estoque negativo', () => {
    cy.get('[data-cy="estoque-produto"]')
      .clear()
      .type('-5')
      .should('have.value', '-5')
      .and(($campo) => {
        expect($campo[0].validity.rangeUnderflow).to.equal(true);
      });
  });

  it('deve impedir texto nos campos numéricos', () => {
    cy.get('[data-cy="preco-produto"]')
      .should('have.attr', 'type', 'number');

    cy.get('[data-cy="estoque-produto"]')
      .should('have.attr', 'type', 'number');

    // Campos type="number" não aceitam texto comum.
    cy.get('[data-cy="preco-produto"]').then(($campo) => {
      const elemento = $campo[0];
      elemento.value = 'abc';

      expect(elemento.value).to.equal('');
    });

    cy.get('[data-cy="estoque-produto"]').then(($campo) => {
      const elemento = $campo[0];
      elemento.value = 'abc';

      expect(elemento.value).to.equal('');
    });
  });
});
