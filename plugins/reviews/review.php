<?php
class Review extends Blob{
	public $view_template = array("review.php", "post.php");
	
	public function review_editor(){
		includeTemplate("review_edit_panel.php");
	}
	
	public function onPreAdminEditor(){
		hook_onto("post_editor_bellow_title", array($this, "review_editor"));
	}
}