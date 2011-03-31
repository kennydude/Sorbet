<?php
// Sorbet Administrator
require "../framework/core.php";

class AdminHomePage extends AdminPage{
	public $isDataPage = false;
	public $template = "admin/home.php";
}

$page = new AdminHomePage();
$page->render();