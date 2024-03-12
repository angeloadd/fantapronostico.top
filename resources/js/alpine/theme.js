export default {
	mode: "cupcake",

	themes: {
		light: "fp2024",
		dark: "fp2024",
	},

	toggle() {
		this.mode = this.themes[this.mode === this.themes.dark ? "light" : "dark"];
	},

	isDarkMode() {
		return this.mode === this.themes.dark;
	},

	getIcon() {
		return this.mode === this.themes.dark ? "☽" : "☼";
	},

	init() {
		this.mode =
			this.themes[
				window.matchMedia?.("(prefers-color-scheme: dark)").matches
					? "dark"
					: "light"
			];
	},
};
