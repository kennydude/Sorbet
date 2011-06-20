<?php
// Extra functions to do with plugins
require_once("core.php");

/*
 * Used on the settings page to reset everything and rebuild it
 * Please note: It doesn't save the settings
 */
function clear_plugin_cache(){
	global $settings;
	$settings->activated_plugins = array();
	$settings->plugin_cache = array("content_types" => array());
}

function activate_plugin($plugin_name){
	global $settings;
	if(is_file("../plugins/$plugin_name/info.json")){
		echo "<PRE>";
		$plugin = @json_decode(file_get_contents("../plugins/$plugin_name/info.json"), true);
		// YAYY
		if(!$plugin){
			return false;
		}
		// Now we parse everything
		// Step 1: Add the actual plugin to settings
		$settings->activated_plugins = $settings->activated_plugins + array($plugin_name);
		// Step 2: Add any content types to plugin cache
		$cache = $settings->plugin_cache;
		foreach($plugin['content_types'] as $key => $v){
			$plugin['content_types'][$key]['plugin_name'] = $plugin_name;
		}
		print_r($plugin['content_types']);
		$cache['content_types'] = 
			$plugin['content_types'] +
			$settings->plugin_cache['content_types'];
		
		$settings->plugin_cache = $cache;
	} else{
		return false;
	}
}
$hooks = array();

function call_hook($hook_name, $args = array()){
	global $hooks;
	if(is_array($hooks[$hook_name])){
		foreach($hooks[$hook_name] as $f){
			call_user_func_array($f, $args);
		}
	}
}

function hook_onto($hook_name, $function){
	global $hooks;
	$hooks[$hook_name][] = $function;
}