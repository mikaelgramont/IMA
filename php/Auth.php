<?php
class Auth
{
	public static function validateAuth($identity, $password)
	{
		$file = file_get_contents(PWFILE);
		$table = json_decode($file, true);

		return isset($table[$identity]) && $table[$identity] == $password;
	}

	public static function getIdentity()
	{
		return $_SESSION['identity'];
	}

	public static function hasAuth()
	{
		return isset($_SESSION['identity']);
	}

	public static function saveAuthStatus($identity, $status)
	{
		if ($status) {
			$_SESSION['identity'] = $identity;	
		} else {
			unset($_SESSION['identity']);
		}
	}
}