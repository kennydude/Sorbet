<?php
require_once("base.php");

/**
 * List of blobs
 * @author kennydude
 *
 */
class BlobList extends Blob{
	public $admin_editor = "admin/list-editor.php";
	
	public function handlePostPostCommit($post){
		$children = array();
		foreach($post['children_title'] as $k => $v)
			$children[$k]['title'] = $v;
		foreach($post['children_body'] as $k => $v)
			$children[$k]['body'] = $v;
		print_r($children);
		foreach($children as $k => $child){
			if(strstr($k, "new-") != false)
				$item = new Blob();
			else
				$item = Blob::getBlob($k);
			$item->title = $child['title'];
			$item->parent = $this->id;
			$item->body = $child['body'];
			$item->content_type = "list_item";
			$item->commit();
		}
		
	}
	
	public static $list_headers = array(
		"title" => "List Title",
		"created" => "Created"
	);
}
