describe('Formulaire Inscription', () => {
    it('test 1 - inscription OK', () => {
      cy.visit('http://127.0.0.1:8000/register');
  
      // Entrer le nom d'utilisateur et le mot de passe
      cy.get('#registration_form_email').type('resgister@test.com');
      cy.get('#registration_form_plainPassword').type('123456');

      // Cocher la case des termes et conditions
      cy.get('#registration_form_agreeTerms').check();
  
      // Soumettre le formulaire
      cy.get('button[type="submit"]').click();
  
      // Vérifier que l'utilisateur est redirigé vers la page de connexion
      cy.url().should('include', '/login');
    });
  
    it('test 2 - inscription KO', () => {
      cy.visit('http://127.0.0.1:8000/register');
  
      // Entrer un nom d'utilisateur et un mot de passe incorrects
      cy.get('#registration_form_email').type('resgister@test.com');
      cy.get('#registration_form_plainPassword').type('123');

      // Cocher la case des termes et conditions
      cy.get('#registration_form_agreeTerms').check();
  
      // Soumettre le formulaire
      cy.get('button[type="submit"]').click();
  
      // Vérifier que le message d'erreur est affiché
      cy.contains('Your password should be at least 6 characters').should('exist');
      cy.contains('There is already an account with this email').should('exist');
    });
  });