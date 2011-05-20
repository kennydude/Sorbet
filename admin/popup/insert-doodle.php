<?php
// Sorbet Administrator
require "core.php";

class AdminInsertDoodlePage extends AdminPopupPage{
	public $template = "admin/popup/insert-doodle.php";
	
	public function fetchData(){
		/*return File::fetchFiles();*/
	}
	
	public function postHandler(){
		$file = new File();
		$data = file_get_contents($_POST['doodle']);
		$file->store_data("doodle.png", $data);
		$this->template = "admin/popup/doodle-done.php";
		return $file;
	}
}

$page = new AdminInsertDoodlePage();
$page->render();