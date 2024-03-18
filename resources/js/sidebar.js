const sideBar = document.getElementById("sideBar");
const asideCloseBtn = document.getElementById("asideCloseBtn");
const asideBtn = document.getElementById("asideBtn");

function handleClick(event) {
	if (
		!sideBar.classList.contains("hidden") &&
		!asideBtn.contains(event.target) &&
		(asideCloseBtn.contains(event.target) || !sideBar.contains(event.target))
	) {
		asideBtn.classList.remove("hidden");
		sideBar.classList.add("hidden");
		sideBar.classList.remove("custom-position");
	}
}

function handleEscape(event) {
	if (!sideBar.classList.contains("hidden") && event.key === "Escape") {
		asideBtn.classList.remove("hidden");
		sideBar.classList.add("hidden");
		sideBar.classList.remove("custom-position");
	}
}
asideBtn?.addEventListener("click", () => {
	sideBar.classList.remove("hidden");
	asideBtn.classList.add("hidden");
	sideBar.classList.add("custom-position");
});

if (sideBar || asideBtn) {
	document.body.addEventListener("click", handleClick);
	document.body.addEventListener("keyup", handleEscape);
}
