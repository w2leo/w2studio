// Attach a click event listener to the submit Lottery button
document.getElementById('submitLottery').addEventListener('click', function () {
	event.preventDefault(); // Prevent the default form submission behavior


	var form = document.querySelector('.needs-validation');
	if (form.checkValidity() === false) {
	  event.stopPropagation();
	  form.classList.add('was-validated');
	  return;
	}

	// Get the user's email address from the input field
	var userEmail = document.getElementById('inputEmail').value;

	// If the email is valid, close the Bootstrap popup and send an AJAX request to the PHP script
	$('#emailHelp').removeClass('text-danger').text("We'll never share your email with anyone else.");

	// Send an AJAX request to the PHP script
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

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

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
