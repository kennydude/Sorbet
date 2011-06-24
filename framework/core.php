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
require_once("plugins.php");

// Error Handling:
function exception_handler($exception) {
	myErrorHandler(-1, $exception->getMessage(),  $exception->getFile(), $exception->getLine());
}
function error($error) { myErrorHandler(-1, $error, "Sorbet", -2); } 

set_exception_handler('exception_handler');

function myErrorHandler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return;
    }
    if($errline > 0)
	$l = "at line $errLine";
    else
	$l = "and Sorbet fired this (code $errline)";
    print <<<EOF
<div class="error" style="font-family:sans-serif;margin: 5px;padding: 10px;border: 2px solid #ff3300; background: #ff9966;">
<b>Sorbet threw an error!</b><br/>
The error was "$errstr"<br/>
It happened in $errfile $l<br/>
Please report this error
</div>
EOF;
	return true;
}
set_error_handler("myErrorHandler");


$autoload_cache = array();
function __autoload($class_name) {
	global $autoload_cache;
	if($autoload_cache[$class_name]){
		if(!@include_once($autoload_cache[$class_name])){
			myErrorHandler(-2, "Autoloading class '$class_name' failed", $autoload_cache[$class_name], -2);
		}
	}
}

function make_proxy_class($type, $file, $className, $plugin){
	global $autoload_cache;
	$file = "../plugins/$plugin/$file";
	$autoload_cache[$className] = $file;
	// Yup this is a mad class name. I know! Look at __autoload to see what we do!
	return $className;
}

function get_embed_types(){
	$base = array(
		"twitter.com" => TwitterEmbed
	);
	return $base;
}

function get_content_types(){
	global $settings;
	$base = array(
		"post" => Post,
		"list" => BlobList,
		"page" => ContentPage,
		"file" => File
	);
	foreach($settings->plugin_cache['content_types'] as $type => $data){
		$base[$type] = make_proxy_class($type, $data['file'], $data['class'], $data['plugin_name']);
	}
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
function put_temp_message($message){
	global $msgs;
	$msgs[] = $message;
}
function get_messages(){
	global $msgs;
	$o = $_SESSION['messages'];
	if(!is_array($o))
		$o = array();
	if(is_array($msgs))
		$o = array_merge($o, $msgs);
	unset($_SESSION['messages']);
	return $o;
}
