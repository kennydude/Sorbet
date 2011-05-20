<?php
// File Storage API
require_once("base.php");

/**
 * Base thumbnail for rendering
 * @author kennydude
 *
 */
class Thumbnail{
	public $file;
	function __construct($file){ $this->file = $file; }
	function render_html($width = 100, $height=100){ return "render_html()"; }
	function to_array(){ return "to_array()"; }
}

/**
 * Thumbnail of a file
 * @author kennydude
 *
 */
class FileThumbnail extends Thumbnail{
	function get_file_extension($file_name){
		return substr(strrchr($file_name,'.'),1);
	}
	function get_image(){
		global $settings;
		$ext_for = array("txt"); # Extensions we support icons for
		$img_for = array("png", "jgep", "jpg");
		$ext = strtolower($this->get_file_extension($this->file));
		if(in_array($ext, $ext_for))
			$i = "templates/admin/res/filetypes/$ext.png";
		else if(in_array($ext, $img_for))
			$i = "thumb.php?width=" . $this->width . "&height=" . $this->height . "&file=" . $this->file;
		else
			$i = "templates/admin/res/filetypes/file.png";
		return $settings->website_root . $i;
	}
	function to_array(){ return $this->get_image(); }
	function render_html($width=100,$height=100){
		$this->width = $width;
		$this->height = $height;
		return "<div class='wraptocenter' style='width:${width}px;height:${height}px;background:#000'><span></spam><img src='".
			$this->get_image()."' /></div>";
	}
}

/**
 * Base file. Extends of blob so it's in the database
 * @author kennydude
 *
 */
class File extends Blob{
	public $content_type = "file";
	public static function fetchFiles($from=0,$filters=array()){
		return File::fetchBlobs($from, "file", $filters);
	}
	
	/**
	 * Put a file into storage
	 * @param array $file
	 */
	public function put_file($file){
		$tmp_name = $file['tmp_name'];
		$file['name'] = str_replace(" ", "_", $file['name']);
		$this->title = substr($file['name'], 0, strpos($file['name'],'.')) . "_" . sha1($file['size'] . $file['name'] . time()) . "."
			. substr(strrchr($file['name'],'.'),1);
		move_uploaded_file($tmp_name, $this->get_internal_url());
		$this->commit();
	}
	
	public function store_data($filename, $data){
		$filename = str_replace(" ", "_", $filename);
		$this->title = substr($filename, 0, strpos($filename,'.')) . "_" . sha1($filename . time()) . "."
			. substr(strrchr($filename,'.'),1);
		file_put_contents($this->get_internal_url(), $data);
		$this->commit();
	}
	
	public function get_url(){
		global $settings;
		return $settings->website_root . "files/" . $this->title;
	}
	
	public function get_internal_url(){
		return realpath("../files/") . "/" . $this->title;
	}
	
	public function get_thumbnail(){
		return new FileThumbnail($this->title);
	}
	public static function getFromSorbetUrl($url = "sorbet://"){
		$url = substr($url, 9);
		$files = File::fetchBlobs(0, "file", array("title" => $url));
		if(empty($files))
			return NULL;
		return $files[0];
	}
}

/**
 * An image in the system
 * @author kennydude
 *
 */
class Image extends File{
	
}