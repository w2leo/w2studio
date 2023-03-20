<?php

enum GetKeys: string
{

}

enum PostKeys: string
{
	case LOGIN = 'login';
	case RECOVERY = 'recovery';
	case SET_PASSWORD = 'set_password';
	case SIGNUP = 'signup';
	case ADD_CITY = 'add_city';
	case REMOVE_CITY = 'remove_city';
}

?>
