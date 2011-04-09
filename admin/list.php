<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminListPage extends AdminPage{
	public $template = "admin/list.php";

	public function onPreRender(){
		parent::onPreRender();
		$uc = ucwords($_GET['type']);
		$content_types = get_content_types();
		$type = $content_types[$_GET['type']];
		if(!$type)
			$type = Blob;
		$get_type = $_GET['type'];
		$this->page_data = array(
			'title' => ucwords($_GET['type'] . "s"),
			'global_actions' => array(
				"New " . $uc => "blob-editor.php?type=$get_type"
			),
			'item_actions' => array(
				"Edit " . $uc => "blob-editor.php?blob=$1"
			),
			'headers' => $type::get_list_headers()
		);
	}
	
	public function fetchData(){
		return Blob::fetchBlobs($_GET['from'], $_GET['type']);
	}
}

$page = new AdminListPage();
$page->render();