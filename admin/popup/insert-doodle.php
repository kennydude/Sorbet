<?php
// Sorbet Administrator
require "core.php";

class AdminInsertMediaPage extends AdminPopupPage{
	public $template = "admin/popup/insert-doodle.php";
	
	public function fetchData(){
		/*return File::fetchFiles();*/
	}
	
	public function postHandler(){
		
	}
}

$page = new AdminInsertMediaPage();
$page->render();