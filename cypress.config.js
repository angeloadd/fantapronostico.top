import { defineConfig } from "cypress";
import runOn from "./tests/cypress/plugins/index.js";

export default defineConfig({
	chromeWebSecurity: false,
	retries: 2,
	defaultCommandTimeout: 5000,
	watchForFileChanges: false,
	videosFolder: "tests/cypress/videos",
	screenshotsFolder: "tests/cypress/screenshots",
	fixturesFolder: "tests/cypress/fixture",
	e2e: {
		setupNodeEvents(on, config) {
			return runOn(on, config);
		},
		baseUrl: "http://127.0.0.1:8001",
		specPattern: "tests/cypress/integration/**/*.{cy,spec}.{js,jsx,ts,tsx}",
		supportFile: "tests/cypress/support/index.js",
	},
});
