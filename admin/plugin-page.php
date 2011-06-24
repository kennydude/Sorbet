<?php
// Sorbet Administrator
require "../framework/core.php";

$pages = explode("/", $_GET['path']);

if(in_array($pages[0], array_keys($settings->plugin_cache["pages"]))){
	$plugin = $settings->plugin_cache['pages'][$pages[0]];
	if(in_array($pages[1], array_keys($plugin))){
		$page = $plugin[$pages[1]];
		if(!@include_once("../plugins/${pages[0]}/${page['file']}")){
			new Error_404("Plugin file couldn't be loaded.");
		}
		$actual_page = new $page['class']();
		$actual_page->render();
	} else{
		new Error_404("Page doesn't exist in that plugin");
	}
} else{
	new Error_404("Plugin doesn't exist, not activated or hasn't requested any pages in it's manifest");
}
