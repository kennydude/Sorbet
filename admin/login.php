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
		$response = auth_user($_POST['username'], $_POST['password'], ($_POST['prehashed'] == "true") );
		if(is_bool($response)){
			header("Location: index.php"); exit("Your browser should now redirect you");
		}
		return $response;
	}
}

$page = new AdminLoginPage();
$page->render();
