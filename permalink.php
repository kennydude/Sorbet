<?php
require_once( "framework/core.php" );

if(!$_GET['id']){
	new Error_404("No item was specified");
	exit();
}

$blob = Blob::getBlob($_GET['id']);
if(!$blob){
	new Error_404("Item doesn't exist!");
	exit();
}

if($settings->enable_rewriting == false){
	$url = $settings->website_root . "?u=" . $blob->url_slug;
} else{
	$url = $settings->website_root . $blob->url_slug;;
}

header("Location: $url");
echo "You should be automatically redirected right now. <a href='$url'>I haven't!</a>";
