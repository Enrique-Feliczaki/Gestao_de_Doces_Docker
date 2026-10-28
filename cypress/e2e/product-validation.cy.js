
import ProductFormPage from '../support/pages/ProductFormPage';

describe('Validação de valores inválidos do produto', () => {
  const form = new ProductFormPage();

  beforeEach(() => {
    form.visitCreate();
  });

  it('deve rejeitar preço negativo', () => {
    cy.get(form.selectors.price)
      .clear()
      .type('-10')
      .should('have.value', '-10')
      .and(($campo) => {
        expect($campo[0].validity.rangeUnderflow).to.equal(true);
      });
  });

  it('deve rejeitar estoque negativo', () => {
    cy.get(form.selectors.stock)
      .clear()
      .type('-5')
      .should('have.value', '-5')
      .and(($campo) => {
        expect($campo[0].validity.rangeUnderflow).to.equal(true);
      });
  });

  it('deve impedir texto nos campos numéricos', () => {
    cy.get(form.selectors.price).should('have.attr', 'type', 'number');
    cy.get(form.selectors.stock).should('have.attr', 'type', 'number');

    cy.get(form.selectors.price).then(($campo) => {
      $campo[0].value = 'abc';
      expect($campo[0].value).to.equal('');
    });

    cy.get(form.selectors.stock).then(($campo) => {
      $campo[0].value = 'abc';
      expect($campo[0].value).to.equal('');
    });
  });

  it('deve identificar e bloquear dados inválidos carregados da fixture', () => {
    cy.fixture('produto-invalido.json').then((produto) => {
      form.fillInvalid(produto);

      cy.get(form.selectors.price).should(($campo) => {
        expect($campo[0].validity.rangeUnderflow).to.equal(true);
      });

      cy.get(form.selectors.category).should('have.value', '');

      cy.get(form.selectors.submit).click();

      cy.location('pathname').should('eq', '/products/create');
      cy.get(form.selectors.name).should('be.visible');
    });
  });
});
