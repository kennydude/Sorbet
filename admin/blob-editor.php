<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminEditorPage extends AdminPage{
	public $template = "admin/editor.php";
	public $page_data = array(
	);
	
	public function onPreRender(){
		parent::onPreRender();
		if($_GET['type']){
			$content_types = get_content_types();
			$type = $content_types[$_GET['type']];
			if(!$type)
				$type = Blob;
			$d = new $type();
			$this->template = $d->admin_editor;
		} else
			$this->template = $this->data->admin_editor;
	}
	
	public function fetchData(){
		return Blob::getBlob($_GET['blob']);
	}
	
	public function postHandler($data){
		$data->title = $_POST['title'];
		$data->body = $_POST['body'];
		$data->status = $_POST['status'];
		$data->url_slug = $_POST['url_slug'];
		if($_GET['type'])
			$data->content_type = $_GET['type'];
		$data->handlePostPreCommit($_POST);
		$data->commit();
		$data->handlePostPostCommit($_POST);
		put_message("Post was saved");
		$url = get_url();
		if(strpos($url, "blob=")!=false)
			$url = $url;
		else if(strpos($url, "?")!=false)
			$url .= '&blob=' . $data->id;
		else
			$url .= '?blob=' . $data->id;
		header("Location: $url");
	}
}
if(!defined("SBE")){
	$page = new AdminEditorPage();
	$page->render();
}
