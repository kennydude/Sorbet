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
	
	/**
	 * Overriding this allows the object to handle more post values than
	 * automatically set by blob-editor.php. However, $id may not be set
	 * @param array $post
	 */
	public function handlePostPreCommit($post){ }
	/**
	 * Overriding this allows you to add children etc, as $id will be
	 * set
	 * @param array $post
	 */
	public function handlePostPostCommit($post){ }
	
	public static $list_headers = array(
		"title" => "Post Title",
		"created" => "Created"
	);
	
	public static function get_list_headers(){
		return static::$list_headers;
	}
	
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
			$result[] = static::arrayToBlob($r);
		}
		return $result;
	}
	
	/***
	 * 
	 */
	public static function fetchBlobs($from, $type="post"){
		if(!$from)
			$from = 0;
		$sql = "SELECT * FROM blobs WHERE `content_type`='$type' LIMIT $from," . ($from+10);
		$data = query_database($sql);
		$result = array();
		foreach($data as $blob){
			$result[] = static::arrayToBlob($blob);
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
		return static::arrayToBlob($data);
	}
	
	/***
	 * Turns a database array into a Blob
	 */
	public static function arrayToBlob($data){
		$content_links = get_content_types();
		$type = $content_links[$data['content_type']];
		if(!$type)
			$type = Blob;
		$item = new $type();
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
			$sql = "INSERT INTO blobs (title,body,created,content_type,parent) VALUES ('".
				e($this->title)."', '".e($this->body)."', NOW(), '".e($this->content_type)."','"
				.e($this->parent)."')";
			query_database($sql);
			$this->id = mysql_insert_id();
		} else{
			query_database("UPDATE blobs SET `title`='".
				e($this->title)."', `body`='".e($this->body)."' WHERE `id`='".e($this->id)."'");
		}
		// Update tags
		Tag::clearForObject($this, "mention");
		preg_match_all("/\@([a-zA-Z0-9]+)/", $this->body, $out);
		$mentions = array();
		foreach($out[1] as $mention){
			if(!$mentions[$mention]){
				$tag = new Tag();
				$tag->type = "mention";
				$tag->text = $mention;
				$tag->_link = $this->id;
				$tag->commit();
				$mentions[$mention] = true; // prevents multiple tags per post
			}
		}
		Tag::clearForObject($this, "hashtag");
		preg_match_all("/\#([a-zA-Z0-9]+)/", $this->body, $out);
		$mentions = array();
		foreach($out[1] as $mention){
			if(!$mentions[$mention]){
				$tag = new Tag();
				$tag->type = "hashtag";
				$tag->text = $mention;
				$tag->_link = $this->id;
				$tag->commit();
				$mentions[$mention] = true; // prevents multiple tags per post
			}
		}
	}
}

/**
 * Another core class: A tag, links things together
 * @author kennydude
 *
 */
class Tag{
	public $type = "default";
	public $text;
	public $_link;
	private $_saved = false;
	
	/**
	 * Gets the linked object
	 */
	public function link(){
		return Blob::getBlob($this->_link);
	}
	
	public static function clearForObject($id, $type = 0){
		if(!is_int($id))
			$id = $id->id;
		$sql = "DELETE FROM tags WHERE `link`='".e($id)."'";
		if(!is_int($type))
			$sql .= " AND `type`='".e($type)."'";
		echo $sql;
		query_database($sql);
	}
	
	/**
	 * Commits the object to the database
	 */
	public function commit(){
		if($this->_saved == false){
			$sql = "INSERT INTO tags (type,link,text) VALUES('".
				e($this->type)."', '".e($this->_link)."', '".e($this->text)."')";
			query_database($sql);
			$this->_saved = true;
		} else{
			
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
	if($r != false){
		$result = array();
		while ($row = @mysql_fetch_array($r)) {
			$result[] = $row;
		}
		@mysql_free_result($r);
		return $result;
	} else{ /* TODO: error handling */ print "db error" . mysql_error(); }
}