<?php
define("SBE", "true");
require("blob-editor.php");

class AdminTagBlobEditorPage extends AdminEditorPage{
	public function fetchData(){
		$blob = Tag::getAppearances($_GET['tag'] . '_' . $_GET['type'], 'tag-description');
		if(is_object($blob[0]))
			$blob = $blob[0]->link();
		else
			$blob = new Blob();
		return $blob;
	}
	public function postHandler($data){
		parent::postHandler($data);
		Tag::clearForObject($data->id);
		$t = new Tag();
		$t->_link = $data->id;
		$t->type = 'tag-description';
		$t->text = $_GET['tag'] . '_' . $_GET['type'];
		$t->commit();
	}
}

$page = new AdminTagBlobEditorPage();
$page->render();
