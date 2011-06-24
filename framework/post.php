<?php
require_once("base.php");

/**
 * Post class
 * @author kennydude
 *
 */
class Post extends Blob{
	public $view_template = "post.php";
	public $admin_editor = "admin/post-editor.php";
	
	/**
	 * Common function to return filters posts to ones that are visible
	 */
	public static function publicFilters(){
		return array(
			"status" => "published",
			"created" => new LessThanFilter(date("Y-m-d H:i:s"))
		);
	}
	
	/***
	 * Get Posts from database
	 */
	public static function getPosts($from = '', $filters = array()){
		return self::fetchBlobs($from,NULL, $filters);
	}
}
