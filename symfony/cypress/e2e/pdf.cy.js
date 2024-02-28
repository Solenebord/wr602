describe('Génération de pdf', () => {
  it('test 1 -Génération OK', () => {

    // inscription

    cy.visit('http://127.0.0.1:8000/register');
    cy.get('#registration_form_email').type('pdf@test.com');
    cy.get('#registration_form_plainPassword').type('123456');
    cy.get('#registration_form_agreeTerms').check()
    cy.get('button[type="submit"]').click();

    // connexion

    cy.visit('http://127.0.0.1:8000/login');
    cy.get('#username').type('pdf@test.com');
    cy.get('#password').type('123456');
    cy.get('button[type="submit"]').click();


    // generation du pdf

    cy.visit('http://127.0.0.1:8000/pdf');
    cy.get('#url').type('https://bigrat.monster/');
    cy.get('#title').type('Test cypress');
    cy.get('button[type="submit"]').click();

    cy.wait(1000);

    // verifier si le titre du pdf existe dans l'historique

    cy.visit('http://127.0.0.1:8000/history');
    cy.contains('Test cypress').should('exist');

    // deconnexion

    cy.visit('http://127.0.0.1:8000/logout');

  });
});