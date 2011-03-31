<?php
require_once("base.php");

/**
 * Post class
 * @author kennydude
 *
 */
class Post extends Blob{
	/***
	 * Get Posts from database
	 */
	public static function getPosts($start = '', $filters = array()){
		$sql = "SELECT * FROM blobs WHERE `content_type`='post'";
		if($start != '')
			$sql .= " AND `id`<" . e($start);
		// TODO: filters
		$sql .= " LIMIT 0,5";
		$objects = query_database($sql);
		$result = array();
		foreach($objects as $object){
			$result[] = Post::arrayToBlob($object);
		}
		return $result;
	}
	
	// TODO: Comments via Disqus
	
	/***
	 * Used for admin etc only, otherwise just use Disqus widget
	 */
	public function comments(){
		
	}
}