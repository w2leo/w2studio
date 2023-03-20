window.addEventListener('DOMContentLoaded', (event) => {
	// Navbar shrink function
	var navbarShrink = function () {
		const navbarCollapsible = document.body.querySelector('#mainNav');
		if (!navbarCollapsible) {
			return;
		}
		if (window.scrollY === 0) {
			navbarCollapsible.classList.remove('navbar-shrink');
		} else {
			navbarCollapsible.classList.add('navbar-shrink');
		}
	};

	// Shrink the navbar
	navbarShrink();

	// Shrink the navbar when page is scrolled
	document.addEventListener('scroll', navbarShrink);

	// Activate Bootstrap scrollspy on the main nav element
	const mainNav = document.body.querySelector('#mainNav');
	if (mainNav) {
		new bootstrap.ScrollSpy(document.body, {
			target: '#mainNav',
			offset: 72
		});
	}

	// Collapse responsive navbar when toggler is visible
	const navbarToggler = document.body.querySelector('.navbar-toggler');
	const responsiveNavItems = [].slice.call(document.querySelectorAll('#navbarResponsive .nav-link'));
	responsiveNavItems.map(function (responsiveNavItem) {
		responsiveNavItem.addEventListener('click', () => {
			if (window.getComputedStyle(navbarToggler).display !== 'none') {
				navbarToggler.click();
			}
		});
	});
});

// Attach a click event listener to the submit Lottery button
document.getElementById('submitLottery').addEventListener('click', function () {
	event.preventDefault(); // Prevent the default form submission behavior
	// Get the user's email address from the input field
	var userEmail = document.getElementById('inputEmail').value;
	// Send an AJAX request to the PHP script
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			document.getElementById('lotteryMessage').textContent = xhr.responseText;
			document.getElementById('inputEmail').value = '';
		}
	};
	xhr.send('userEmail=' + userEmail);
});
