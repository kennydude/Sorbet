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
		if($this->preview == true)
			return;
		if($_GET['type']){
			$content_types = get_content_types();
			$type = $content_types[$_GET['type']];
			if(!$type)
				$type = Blob;
			$d = new $type();
			$d->onPreAdminEditor();
			$this->template = $d->admin_editor;
		} else{
			$this->data->onPreAdminEditor();
			$this->template = $this->data->admin_editor;
		}
	}
	
	public function fetchData(){
		return Blob::getBlob($_GET['blob']);
	}
	
	public function postHandler($data){
		$data->title = $_POST['title'];
		$data->body = $_POST['body'];
		$data->status = $_POST['status'];
		$data->url_slug = $_POST['url_slug'];
		$ptime = $_POST['date'];
		$date = new DateTime();
		$date->setDate($ptime['year'], $ptime['month'], $ptime['day']);
		$date->setTime($ptime['hour'], $ptime['min']);
		$data->created = $date->format('Y-m-d H:i:s');
		if($_GET['type'])
			$data->content_type = $_GET['type'];
		$data->extra_data = $_POST['extra_data'];
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
		global $settings;
		if($settings->debug == true && $_GET['debug'] == true)
			return;
		header("Location: $url");
		exit(); // No need to give db more load ;)
	}
}
if(!defined("SBE")){
	$page = new AdminEditorPage();
	$page->render();
}
