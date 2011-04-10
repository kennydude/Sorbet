<?php
require_once("base.php");

class ContentPage extends Blob{
	public $view_template = "post.php";
	public $admin_editor = "admin/post-editor.php";
	public $content_type = "page";
}