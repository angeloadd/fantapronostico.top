describe("A user should be able to", () => {
	it("see image in login/register route for viewports greater-equal than 1024px", () => {
		cy.viewport(1024, 800);
		cy.visit("/login");
		cy.get("aside img").should("be.visible");
		cy.visit("/register");
		cy.get("aside img").should("be.visible");
	});
	it("not see image for viewport less than 1024px", () => {
		cy.viewport(1023, 800);
		cy.visit("/register");
		cy.get("aside img").should("not.be.visible");
		cy.visit("/login");
		cy.get("aside img").should("not.be.visible");
	});
	it("navigate to login from register", () => {
		cy.visit("/register");
		cy.get('a[href$="/register"]')
			.contains("Iscriviti")
			.should("have.class", "disabled");
		cy.get('a[href$="/login"]').contains("Accedi").click();
		cy.url().should("contain", "login");
		cy.get('a[href$="/login"]')
			.contains("Accedi")
			.should("have.class", "disabled");
	});
	it("navigate to register from login", () => {
		cy.visit("/login");
		cy.get('a[href$="/login"]')
			.contains("Accedi")
			.should("have.class", "disabled");
		cy.get('a[href$="/register"]').contains("Iscriviti").click();
		cy.url().should("contain", "register");
		cy.get('a[href$="/register"]')
			.contains("Iscriviti")
			.should("have.class", "disabled");
	});
});
