<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminOAuthPage extends AdminPage{
	public $isDataPage = false;
	public $masterPage;
	public $apiOnly = true;
	public $loginPage = true;
	
	public function postHandler(){
		if($_POST['app_name'] && $_POST['app_dev'] && $_POST['app_permissions']){
			$token = new oAuthToken();
			$token->status = "no_auth";
			$token->title = sha1($_POST['app_name'] . time());
			$token->commit();
			// TODO: Save the name & dev & perms
			return array(
				"status" => "good",
				"token" => $token->title
			);
		} else{
			return array(
				"status" => "error",
				"reason" => "details not filled in"
			);
		}
	}
}

$page = new AdminOAuthPage();
$page->render();