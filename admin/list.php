<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

function human_content_types(){
	$keys = array_keys(get_content_types());
	$r = array();
	foreach($keys as $key){
		$r[$key] = array(
			"humans" => ucwords($key . "s")
		);
	}
	return $r;	
}

class AdminContentTypeListPage extends AdminPage{
	public $apiOnly = true;
	public function fetchData(){
		return human_content_types();
	}
}

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
			'content_types' => human_content_types(),
			'headers' => $type::get_list_headers()
		);
	}
	
	public function fetchData(){
		return Blob::fetchBlobs($_GET['from'], $_GET['type']);
	}
}

if($_GET['type'] == "content_types"){
	$page = new AdminContentTypeListPage();
} else{
	$page = new AdminListPage();
}
$page->render();
