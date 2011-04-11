<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

function get_tag_url($in){
	return "view-tag.php?tag=${in['text']}&type=${in['type']}";
}

class AdminTagListPage extends AdminPage{
	public $template = "admin/list.php";
	public $page_data = array(
		'title' => "Tags",
		'global_actions' => array( ),
		'item_actions' => array(
			"View" => get_tag_url
		),
		'headers' => array(
			"type" => "Type",
			"text" => "Name"
		)
	);

	public function onPreRender(){
		parent::onPreRender();
		$uc = ucwords($_GET['type']);
		$content_types = get_content_types();
		$type = $content_types[$_GET['type']];
		if(!$type)
			$type = Blob;
		$get_type = $_GET['type'];
		
	}
	
	public function fetchData(){
		return Tag::getTags();
	}
}

$page = new AdminTagListPage();
$page->render();
