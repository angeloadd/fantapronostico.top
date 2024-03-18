import htmx from "htmx.org";
import "./alpine";
import "./sidebar";
import "./util";
import './countdown'
import './gameNav'

import.meta.glob(["../assets/images/**"]);

htmx.config.withCredentials = true;

document.body.addEventListener("htmx:configRequest", (event) => {
	event.detail.headers["X-CSRF-TOKEN"] = document
		.querySelector('meta[name="_token"]')
		.getAttribute("content");
	event.detail.headers["X-Requested-With"] = "XMLHttpRequest";
});
