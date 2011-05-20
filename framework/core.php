<?php
chdir(dirname(__FILE__));
require_once("base.php");
require_once("post.php");
require_once("./list.php");
require_once("mvc.php");
require_once("./page.php");
require_once("file-storage.php");
require_once("embed.php");
require_once("settings.php");
$settings = new Settings();
if($settings->settingsWorking == false){
	new Error_Misconfig("Sorbet is not configured. Please navigate to /admin/installer.php");
}

function get_embed_types(){
	$base = array(
		"twitter.com" => TwitterEmbed
	);
	return $base;
}

function get_content_types(){
	$base = array(
		"post" => Post,
		"list" => BlobList,
		"page" => ContentPage,
		"file" => File
	);
	return $base;
}

// Set up database
if(!mysql_connect($settings->mysql_host, $settings->mysql_username, $settings->mysql_password)){
	new Error_Misconfig("Couldn't connect to database");
}
if(!mysql_select_db($settings->mysql_database)){
	new Error_Misconfig("Couldn't select database");
}
session_start();

function put_message($message){
	$_SESSION['messages'][] = $message;
}
function get_messages(){
	$o = $_SESSION['messages'];
	unset($_SESSION['messages']);
	if(empty($o))
		return array();
	return $o;
}