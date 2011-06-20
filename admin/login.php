<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminLoginPage extends AdminPage{
	public $isDataPage = false;
	public $masterPage;
	public $loginPage = true;
	public $template = "admin/login.php";
	
	public function postHandler(){
		if(auth_user($_POST['username'], $_POST['password'])){
			header("Location: index.php"); exit("Your browser should now redirect you");
		}
		return "auth_error";
	}
}

$page = new AdminLoginPage();
$page->render();