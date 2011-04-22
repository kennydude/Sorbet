<?php
// Sorbet index file
require "framework/core.php";

class HomePage extends Page{
	public $masterPage = "main.php";
	public function fetchData(){
		// TODO!
	}
}

/**
 * Shows a blob
 * @author kennydude
 *
 */
class BlobViewPage extends Page{
	public $masterPage = "main.php";
	
	public function fetchData(){
		return Blob::getBlobBySlug($_GET['u']);
	}
	
	public function onPreRender(){
		$this->title = $this->data->title;
		$this->template = $this->data->view_template;
	}
}

if($_GET['u']){
	$page = new BlobViewPage();
} else{
	$page = new HomePage();
}
$page->render();