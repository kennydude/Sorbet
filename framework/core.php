<?php
require_once("base.php");
require_once("post.php");
require_once("mvc.php");

// Set up database
// TODO: Settings. Note: These settings are only for my system
// they won't work for anything else, nor for anything I have
// that's live :P
mysql_connect("localhost", "root", "omnitrix");
mysql_select_db("Sorbet");
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