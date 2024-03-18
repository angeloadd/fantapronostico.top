import daisyui from "daisyui";
import * as themes from "daisyui/src/theming/themes";

export default {
	content: [
		"./app/Modules/**/Views/**/*.blade.php",
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
	],
	theme: {
		extend: {},
	},
	plugins: [daisyui],
	daisyui: {
		themes: [
			"nord",
			{
				fp2024: {
					...themes.nord,
					primary: "#00AACC",
					secondary: "#01B359",
					accent: "#00849E",
					neutral: "#13525F",
					info: "#14B0D0",
					success: "#01DB6E",
					"primary-content": themes.nord["base-100"],
					"secondary-content": themes.nord["base-100"],
					"accent-content": themes.nord["base-100"],
					"info-content": themes.nord["base-100"],
					"success-content": themes.nord["base-100"],
					"error-content": themes.nord["base-100"],
					"warning-content": themes.nord["base-100"],
				},
			},
		],
	},
};
