<?php
// Sorbet base. Contains core API

/**
 * Base class for Sorbet
 * @author kennydude
 *
 */
class Blob{
	public $title = "";
	public $body = "";
	public $content_type = "blob";
	public $extra_data = array();
	public $created = "";
	private $_parent = "";
	public $id;
	
	/***
	 * Return the body as HTML and not Markdown
	 */
	public function body_html(){
		
	}
	
	/**
	 * This will fetch the parent from the database
	 */
	public function getParent(){
		return Blob::getBlob($this->_parent);
	}
	
	/**
	 * This will fetch the children from the database
	 */
	public function getChildren(){
		$data = query_database("SELECT * FROM blobs WHERE `parent`='".e($this->id)."'");
		$result = array();
		foreach($data as $r){
			$result[] = Blob::arrayToBlob($result);
		}
		return $result;
	}
	
	/***
	 * Will get the blob from the database. This will probably only be used
	 * by the lower classes.
	 */
	public static function getBlob($id){
		$data = query_database("SELECT * FROM blobs WHERE `id`='".e($id)."'");
		$data = $data[0];
		return Blob::arrayToBlob($data);
	}
	
	/***
	 * Turns a database array into a Blob
	 */
	public static function arrayToBlob($data){
		$item = new static();
		$item->title = $data['title'];
		$item->content_type = $data['content_type'];
		$item->id = $data['id'];
		$item->body = $data['body'];
		$item->created = $data['created'];
		$item->_parent = $data['parent'];
		return $item;
	}
	
	/***
	 * Saves the object to the database
	 */
	public function commit(){
		if(is_null($this->id)){
			// INSERT
		} else{
			// UPDATE
		}
	}
}

/**
 * Shorthand for mysql_real_escape_string
 * @param $i
 */
function e($i){ return @mysql_real_escape_string($i); }

/**
 * Query the database and return the array as a result!
 * @param string $sql
 */
function query_database($sql){
	$r = @mysql_query($sql);
	if($r){
		$result = array();
		while ($row = mysql_fetch_array($r)) {
			$result[] = $row;
		}
		mysql_free_result($r);
		return $result;
	} else{ /* TODO: error handling */ print "db error" . mysql_error(); }
}