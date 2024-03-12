import Alpine from "alpinejs";
import theme from "./theme.js";

window.Alpine = Alpine;

Alpine.store("theme", theme);

Alpine.start();
