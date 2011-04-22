<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminSettingsPage extends AdminPage{
	public $template = "admin/settings.php";
	
	function fetchData(){
		global $settings;
		return $settings->getPrettyNames();
	}
}
$page = new AdminSettingsPage();
$page->render();