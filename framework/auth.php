<?php
// Auth Framework
require_once("base.php");

// TODO: Live in settings and random
$salt = "moonpig.com";

class User{
	public $username;
	public $password;
	public $name;
	public $salt;
	
	public function validatePassword($password, $preHashed = false){
		global $settings;
		if($preHashed == false){
			$password = sha1("$password-" . $settings->salts[1]);
		}
		$sha1 = $settings->salts[0]."-$password-" . $this->salt;
		$sha1 = sha1($sha1);
		if($sha1 == $this->password)
			return true;
		return false;
	}
	
	public static function getUserByUsername($username){
		$data = get_data("users", array(
			"username" => $username
		));
		if(count($data) == 0)
			return;
		$data = $data[0];
		return User::userFromArray($data);
	}
	
	public static function userFromArray($array){
		$item = new static();
		$item->username = $array['username'];
		$item->password = $array['password'];
		$item->name = $array['name'];
		$item->salt = $array['salt'];
		return $item;
	}
}

class oAuthToken extends Blob{
	public $content_type = "oAuthToken";
}

function auth_user($username, $password, $preHashed = false){
	$user = User::getUserByUsername($username);
	if($user == NULL)
		return "username";
	if($user->validatePassword($password, $preHashed)){
		$_SESSION['ADMIN_AUTH'] = $user->username;
		return true;
	}
	return "password";
}
