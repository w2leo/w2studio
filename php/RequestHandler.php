<?php

require_once('handlers/GetPostEnum.php');
require_once('db/udf.php');

class RequestHandler
{
	public function DefaultPage()
	{
		if (isset($_SESSION['username'])) {
			include "views/main.php";
		} else {
			include "views/login.php";
		}
	}
	public function HandleGET($keys)
	{
		if (count($keys) == 0) {
			$this->DefaultPage();
		}

		foreach ($keys as $key) {
			switch ($key) {
				case GetKeys::CONFIRMATION_TOKEN->value:
					include "handlers/confirmation_token.php";
					return;
				case GetKeys::RECOVERY_TOKEN->value:
					include "handlers/recovery_token.php";
					return;
				case GetKeys::MAIN->value:
					include "handlers/main.php";
					return;
				case GetKeys::LOGOUT->value:
					include "handlers/logout.php";
					return;
				case GetKeys::RECOVERY->value:
					include "views/recovery.php";
					return;
				case GetKeys::SIGNUP->value:
					include "views/signup.php";
					return;
			}
		}

	}

	public function HandlePOST($keys)
	{
		foreach ($keys as $key) {
			switch ($key) {
				case PostKeys::LOGIN->value:
					include "handlers/login.php";
					break;
				case PostKeys::RECOVERY->value:
					include "handlers/recovery.php"; // into post
					break;
				case PostKeys::SET_PASSWORD->value:
					include "handlers/set_new_password.php";
					break;
				case PostKeys::SIGNUP->value:
					include "handlers/signup.php"; // into post
					break;
				case PostKeys::ADD_CITY->value:
					include "handlers/main.php";
					break;
				case PostKeys::REMOVE_CITY->value:
					include "handlers/main.php";
					break;
			}
		}
		ExitPage('');
	}

}

?>
