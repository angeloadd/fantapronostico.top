const gameBar = document.getElementById("gameBar");
const nextGameBtn = document.getElementById("nextGameBtn");
const previousGameBtn = document.getElementById("previousGameBtn");

if (gameBar) {
	document.body.addEventListener("keyup", (event) => {
		if (nextGameBtn && event.key === "ArrowRight") {
			window.location.assign(nextGameBtn.getAttribute("href"));
		}
		if (previousGameBtn && event.key === "ArrowLeft") {
			window.location.assign(previousGameBtn.getAttribute("href"));
		}
	});
}
