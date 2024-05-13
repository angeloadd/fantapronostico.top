const sideBar = document.getElementById("sideBar");
const asideBtn = document.getElementById("asideBtn");

function handleEscape(event) {
	if (sideBar.classList.contains("drawer-open") && event.key === "Escape") {
		asideBtn.classList.remove("hidden");
		sideBar.classList.remove("drawer-open");
	}
}

if (sideBar || asideBtn) {
	document.body.addEventListener("keyup", handleEscape);
}
