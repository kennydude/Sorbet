<?php
define("INCLUDE_INDEX", "");
include("../index.php");

class BlobPreviewPage extends BlobViewPage{
	public function fetchData(){
		global $post_response;
		return $post_response;
	}
}

$preview = new BlobPreviewPage();
$preview->render();