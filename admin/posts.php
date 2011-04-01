<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";

class AdminPostListPage extends AdminPage{
	public $template = "admin/list.php";
	public $page_data = array(
		"title" => "Posts",
		"global_actions" => array(
				"New Post" => "post-editor.php"	
			),
		"item_actions" => array(
				"Edit Post" => "post-editor.php?post=$1"
			),
		"headers" => array(
				"title" => "Post Title",
				"created" => "Created"
			)
	);
	
	public function fetchData(){
		return Post::getPosts();
	}
}

$page = new AdminPostListPage();
$page->render();