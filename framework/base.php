<?php
// Sorbet base. Contains core API
require_once("db.php");
require_once("markdown.php");

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
	public $url_slug = "";
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
		return Markdown($this->body);
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
		$data = get_data('blobs', array('parent'=>$this->id));
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
		$data = get_data('blobs', array('content_type'=>$type), $from, $from+10);
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
		$data = get_data('blobs', array('id' => $id));
		$data = $data[0];
		return static::arrayToBlob($data);
	}
	
	/**
	 * Will get the blob for the url
	 * @param string $slug
	 */
	public static function getBlobBySlug($slug){
		$data = get_data('blobs', array('url_slug' => $slug));
		$data = $data[0];
		return static::arrayToBlob($data);
	}
	
	/***
	 * Turns a database array into a Blob
	 */
	public static function arrayToBlob($data){
		if(!$data)
			return NULL;
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
		$item->url_slug = $data['url_slug'];
		$item->_parent = $data['parent'];
		return $item;
	}
	
	/**
	 * Outputs the Blob as a php array
	 */
	public function to_array(){
		return array(
			"title" => $this->title,
			"body" => $this->body,
			"created" => time(),
			"content_type" => $this->content_type,
			"id" => $this->id,
			"parent" => $this->parent,
			"url_slug" => $this->url_slug
		);
	}
	
	/***
	 * Saves the object to the database
	 */
	public function commit(){
		put_data('blobs', $this->to_array());
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
		$sql = "DELETE FROM tags WHERE `link`='".e($id)."'"; // TODO: Move to db.php
		if(!is_int($type))
			$sql .= " AND `type`='".e($type)."'";
		echo $sql;
		query_database($sql);
	}
	
	/**
	 * Commits the object to the database
	 */
	public function commit(){
		put_data('tags', array(
			"type" => $this->type,
			"link" => $this->_link,
			"text" => $this->text
		));
		$this->_saved = true;
	}
}