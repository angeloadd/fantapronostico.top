// Set the date we're counting down to
if (document.getElementById("countDown")) {
	const countDown = document.getElementById("countDown");
	const gameDate = countDown.getAttribute("data-date");
	const countDownDate = new Date(gameDate.replace(" ", "T")).getTime();

	// Update the count down every 1 second
	const x = setInterval(() => {
		// Get today's date and time
		const now = new Date().getTime();
		// Find the distance between now and the count down date
		const distance = countDownDate - now;
		// Time calculations for days, hours, minutes and seconds
		const days = Math.floor(distance / (1000 * 60 * 60 * 24));
		const hours = Math.floor(
			(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
		);
		const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		const seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Display the result in the element with id="countDown"
		countDown.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

		// If the count down is finished, write some text
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("countDown").innerHTML = "Pronositici";
		}
	}, 1000);
}
