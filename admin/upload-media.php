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
		print_r( $_FILES );
		// TODO: Add to file API to actually store these images!
	}
}

$page = new AdminUploadMediaPage();
$page->render();