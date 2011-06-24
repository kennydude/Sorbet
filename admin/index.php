<?php
// Sorbet Administrator
require "../framework/core.php";

class AdminHomePage extends AdminPage{
	public $template = "admin/home.php";

	public function fetchData(){
		global $settings;
		$engine_setup = $settings->comment_engine;
		$comment_data = $engine_setup['name'];
		$comment_data = $comment_data::getDashboardInfo();
		return array(
			"comment_data" => $comment_data
		);
	}
}

$page = new AdminHomePage();
$page->render();
