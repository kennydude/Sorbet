<?php
// Sorbet base. Contains core API
require_once("db.php");
require_once("markdown_extra.php");

/**
 * Base class for Sorbet
 * @author kennydude
 *
 */
class Blob{
	public $title = "";
	public $view_template = "post.php";
	public $admin_editor = "admin/post-editor.php";
	public $body = "";
	public $content_type = "blob";
	public $extra_data = array();
	public $url_slug = "";
	public $created = "";
	private $_parent = "";
	public $status = "";
	public $id;
	public $mention_url = "?tag=$1&type=mention";
	
	/**
	 * Called to add hooks
	 */
	public function onPreAdminEditor(){ }
	
	public function __construct(){
		$this->created = "now";
	}
	
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
		$markdown = new SorbetMarkdown();
		$o = $markdown->transform($this->body);
		// Extra from markdown
		$o = preg_replace("/\@([a-zA-Z0-9]+)/", "@<a href='".$this->mention_url."'>$1</a>", $o);
		return $o;
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
	public static function fetchBlobs($from, $type=NULL,$filters=array()){
		if(!$from)
			$from = 0;
		$filters[] = new LimitFilter($from, $from+10);
		if($type != NULL)
			$filters['content_type'] = $type;
		$data = get_data('blobs', $filters);
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
			return new Blob();
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
		$item->status = $data['status'];
		$item->url_slug = $data['url_slug'];
		$item->_parent = $data['parent'];
		$textra = get_data('extra_data', array('link' => $item->id));
		foreach($textra as $extra){
			if($extra['type'] == "EXTRA"){
				$item->extra_data[$extra['key']] = $extra['value'];
			}
		}
		return $item;
	}
	
	/**
	 * Outputs the Blob as a php array
	 */
	public function to_array(){
		return array(
			"title" => $this->title,
			"body" => $this->body,
			"created" => $this->created,
			"content_type" => $this->content_type,
			"id" => $this->id,
			"parent" => $this->parent,
			"url_slug" => $this->url_slug,
			"status" => $this->status
		);
	}
	
	/***
	 * Saves the object to the database
	 */
	public function commit(){
		if($this->url_slug == ""){ // automatically generate one
			$oturl = strtolower($this->title); // lowercase
			$oturl = preg_replace("[^A-Za-z0-9]", "", $oturl ); // remove non-alpha
			$oturl = str_replace(" ", "_", $oturl); // Space to _
			$turl = $oturl;
			$okay = false;
			$attempt = 1;
			while($okay == false && $attempt < 5){ // 5 Attempts or fail!
				$tdata = self::fetchBlobs(0, NULL, array("url_slug" => $turl));
				if(empty($tdata)){
					$okay = true;
				} else{
					$turl = $oturl . $attempt;
					$attempt += 1;
				}
			}
			if($okay == false){
				$turl = "temp" + time(); // Hard way
			}
			$this->url_slug = $turl;
		}
		put_data('blobs', $this->to_array());
		$id = mysql_insert_id();
		if($id != 0)
			$this->id = $id;
		// TODO: THIS WILL NEED MOVING! :D
		mysql_query("DELETE FROM extra_data WHERE `link`='".$this->id."}'");
		foreach($this->extra_data as $key => $value){
			put_data("extra_data", array(
				"link" => $this->id,
				"type" => "EXTRA",
				"key" => $key,
				"value" => $value
			));
		}
		// Update tags. TODO: CLEAROUT!
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
		$sql = "DELETE FROM extra_data WHERE `type`='TAG' `link`='".e($id)."'"; // TODO: Move to db.php
		if(!is_int($type))
			$sql .= " AND `type`='".e($type)."'";
		// echo $sql;
		query_database($sql);
	}

	public function to_array($includeBlob = false){
		$o = array(
			"type" => $this->type,
			"text" => $this->text,
			"blob_id" => $this->_link
		);
		if($includeBlob)
			$o['blob'] = $this->link()->to_array();
		return $o;
	}
	
	public static function getAppearances($tagText = '', $tagType=''){
		$data = get_data('extra_data', array('key' => $tagType, 'value' => $tagText));
		$r = array();
		foreach($data as $t){
			$i = new Tag();
			$i->type = $t['type'];
			$i->text = $t['text'];
			$i->_link = $t['link'];
			$r[] = $i;
		}
		return $r;
	}

	public static function getTags(){
		$data = get_data("extra_data", array(
			new GroupByFilter(array("value", "key"))
		));
		//$sql = "SELECT * FROM tags GROUP BY text, type";
		//$data = query_database($sql);
		$r = array();
		foreach($data as $tag){
			$r[] = array(
				"type" => $tag['type'],
				"text" => $tag['text']
			);
		}
		return $r;
	}	

	/**
	 * Commits the object to the database
	 */
	public function commit(){
		put_data('tags', array(
			"key" => $this->type,
			"link" => $this->_link,
			"value" => $this->text
		));
		$this->_saved = true;
	}
}

function get_url(){
	return "http://${_SERVER['HTTP_HOST']}${_SERVER['PHP_SELF']}?${_SERVER['QUERY_STRING']}";
}
