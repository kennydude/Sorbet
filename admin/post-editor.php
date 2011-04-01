<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminPostEditorPage extends AdminPage{
	public $template = "admin/editor.php";
	public $page_data = array(
	);
	
	public function fetchData(){
		return Post::getBlob($_GET['post']);
	}
	
	public function postHandler($data){
		$data->title = $_POST['title'];
		$data->body = $_POST['body'];
		$data->content_type = "post";
		$data->commit();
		put_message("Post was saved");
		header("Location: post-editor.php?post=" . $data->id);
		exit();
	}
}

$page = new AdminPostEditorPage();
$page->render();