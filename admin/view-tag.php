<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

function get_tag_url($in){
	return "view-tag.php?tag=${in['text']}&type=${in['type']}";
}

class AdminTagViewPage extends AdminPage{
	public $template = "admin/view-tag.php";
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
		$blob = Tag::getAppearances($_GET['tag'] . '_' . $_GET['type'], 'tag-description');
		$a = Tag::getAppearances($_GET['tag'], $_GET['type']);
		$appears = array();
		foreach($a as $b)
			$appears[] = $b->to_array(true);
		if(is_object($blob[0]))
			$blob = $blob[0]->link()->to_array();
		return array(
			"description" => $blob,
			"appearances" => $appears
		);
	}
}

$page = new AdminTagViewPage();
$page->render();
