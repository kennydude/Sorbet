<?php
// Sorbet Administrator
require "../framework/core.php";

class AdminUploadMediaPage extends AdminPage{
	public $template = "admin/upload-media.php";
	public $isDataPage = false;
	
	public function onPreRender(){
		parent::onPreRender();
		if($_GET['popup'] == "true")
			$this->masterPage = "admin/popup.php";
	}
	
	public function postHandler(){
		foreach($_FILES as $file){
			if ($file['error'] == 0) {
				$sfile = new File();
				$sfile->put_file($file);
			}
		}
		put_message("Your files were uploaded");
		if($_GET['popup'] == "true"){
			header("Location: popup/insert-media.php");
			exit();
		} 
	}
}

$page = new AdminUploadMediaPage();
$page->render();