// Attach a click event listener to the submit Lottery button
document.getElementById('submitLottery').addEventListener('click', function (event) {
	event.preventDefault(); // Prevent the default form submission behavior
	// Validate email
	var form = document.querySelector('.needs-validation');
	if (form.checkValidity() === false) {
	  event.stopPropagation();
	  form.classList.add('was-validated');
	  return;
	}
	// Clear server message
	document.getElementById('lotteryMessage').textContent = '';
	// Get the user's email address from the input field
	var userEmail = document.getElementById('inputEmail').value;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			document.getElementById('lotteryMessage').textContent = xhr.responseText;
		}
	};
	xhr.send('userEmail=' + userEmail);
});

// Close video on modal closing
function stopVideoOnModalClose(videoId) {
	// Get the video element by ID
	var video = document.getElementById(videoId);
	video.pause();
}

$('.modal').on('hidden.bs.modal', function (event) {
	// Get the ID of the video element from the closed modal
	var videoId = $(event.target).find('video').attr('id');
	// Call the stopVideoOnModalClose function with the ID of the video element
	stopVideoOnModalClose(videoId);
});
