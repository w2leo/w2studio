<?php

// ini_set ('display_errors', 1);
// ini_set ('display_startup_errors', 1);
// error_reporting (E_ALL);

require_once('db/Validation.php');
require_once('handlers/RequestHandler.php');

//enable input bufferization
ob_start();

session_start();

/* ----------- debug info ----------- */
// foreach ($_SESSION['message'] as $key => $item) {
// 	echo '<p class="text-danger">message #'.$key.': '.$item.'</p>';
// }
// $_SESSION['message'] = [];

// init session from config.ini file
$_SESSION['config'] = parse_ini_file("config.ini", true)[$_SERVER['SERVER_NAME']];

// create RequestHandler object for handle GET and POST requests
$requestHandler = new RequestHandler();
if (!isset($_GET) && !isset($_POST))
	$requestHandler->DefaultPage();

try {
	//Check and validate GET and POST requests
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET)) {
		Validation::ValidateArray($_GET);
		$requestHandler->HandleGET(array_keys($_GET));
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
		Validation::ValidateArray($_POST);
		$requestHandler->HandlePOST(array_keys($_POST));
	}
} catch (Error $e) {
	ExitPage('');
}

?>
