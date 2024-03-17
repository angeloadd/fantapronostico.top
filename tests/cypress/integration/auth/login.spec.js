describe("A user should be able to", () => {
	beforeEach(function () {
		cy.fixture("user").then((user) => {
			this.validUser = user.validUser;
		});
		cy.artisan("migrate:fresh --env=cypress");
	});
	it("create an account and be redirected to verify-email page", function () {
		const { email, name, password } = this.validUser;
		cy.visit("register");
		cy.get('input[type="email"').type(email);
		cy.get('input[type="text"').type(name);
		cy.get('input[type="password"').type(password);
		cy.get(".form-control button").click();
		cy.url().should("contain", "verify-email");
		cy.currentUser().should("not.be.null");
	});
	it("login and be redirected to verify-email page if not verified", function () {
		this.validUser.email_verified_at = null;
		cy.login(this.validUser);
		cy.logout();
		cy.visit("login");
		cy.get('input[type="email"').type(this.validUser.email);
		cy.get('input[type="password"').type(this.validUser.password);
		cy.get(".form-control button").click();
		cy.url().should("contain", "verify-email");
		cy.currentUser().should("not.be.null");
	});
	it("login and be redirected to home if already verified", function () {
		cy.login(this.validUser);
		cy.logout();
		cy.visit("login");
		cy.get('input[type="email"').type(this.validUser.email);
		cy.get('input[type="password"').type(this.validUser.password);
		cy.get(".form-control button").click();
		cy.get(".btn-circle").should("contain", "Logout");
	});
});
