<?php

define('EMAIL', 'w2studio@rfbuild.ru');

ini_set('display_errors', 0);
// ini_set ('display_startup_errors', 1);
// error_reporting (E_ALL);

require_once('php/AwsSES.php');
require_once('php/LotterySender.php');
require_once('php/Validation.php');

//enable input bufferization
ob_start();

session_start();

//Clear
unset($_SESSION['lotMessage']);

/* ----------- debug info ----------- */
// foreach ($_SESSION['message'] as $key => $item) {
// 	echo '<p class="text-danger">message #'.$key.': '.$item.'</p>';
// }
// $_SESSION['message'] = [];

try {
	//Check and validate GET and POST requests
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET)) {
		Validation::ValidateArray($_GET);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
		Validation::ValidateArray($_POST);

		if (isset($_POST['userEmail'])) {
			$db = new LotterySender($_POST['userEmail']);
			$result = $db->SendEmail();
			echo $result->value;
			return;
			// $_SESSION['lotMessage'] = $result->value;
		} else {
			SendFormEmail(file_get_contents('php://input'));
		}
	}
	include('main.php');
} catch (Error $e) {
	return;
}

function SendFormEmail($json_str)
{
	$json_obj = json_decode($json_str);
	SendMessage(EMAIL, PrepareMessage($json_obj));
}


function PrepareMessage($json_obj)
{
	$msg = '<h3> You get message from w2studio contact form</h3>';
	$msg .= '<p> Full name: ' . $json_obj->name . '</p><br>';
	$msg .= '<p> Contact data:' . '</p><br>';
	$msg .= '<p> Email: ' . $json_obj->email . '</p><br>';
	$msg .= '<p> Phone: ' . $json_obj->phone . '</p><br>';
	$msg .= '<p> Message: ' . $json_obj->message . '</p><br>';
	return $msg;
}

function SendMessage($email, $message)
{
	$ses = new AwsSES();
	return $ses->SendEmail($email, $message);
}

?>
