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
	
	public function validatePassword($password){
		global $salt;
		$sha1 = "$salt-$password-" . $this->salt;
		$sha1 = sha1($sha1);
		if($sha1 == $this->password)
			return true;
		return false;
	}
	
	public static function getUserByUsername($username){
		$sql = "SELECT * FROM users WHERE `username`='" . e($username) . "'";
		$data = query_database($sql);
		$data = $data[0];
		if(!$data)
			return;
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

function auth_user($username, $password){
	$user = User::getUserByUsername($username);
	if(!$user)
		return false;
	if($user->validatePassword($password)){
		$_SESSION['ADMIN_AUTH'] = $user->username;
		return true;
	}
	return false;
}