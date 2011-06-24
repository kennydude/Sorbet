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
	$settings->plugin_cache = array("content_types" => array(),"hook_cache"=>array(),"pages"=>array());
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
		if(!in_array($plugin_name, $settings->activated_plugins)){
			$plugins = $settings->activated_plugins;
			$plugins[] = $plugin_name;
			$settings->activated_plugins = $plugins;
		}
		// Step 2: Cache everything we need
		$cache = $settings->plugin_cache;
		if($plugin['content_types']){
			foreach($plugin['content_types'] as $key => $v){
				$plugin['content_types'][$key]['plugin_name'] = $plugin_name;
			}
			$cache['content_types'] = 
				$plugin['content_types'] +
				$settings->plugin_cache['content_types'];
		} if($plugin['hooks']){
			foreach($plugin['hooks'] as $key => $v){
				$plugin['hooks'][$key]['plugin_name'] = $plugin_name;
			}
			$cache['hook_cache'] =
				$plugin['hooks'] +
				$settings->plugin_cache['hook_cache'];
		} if($plugin['pages']){
			$cache['pages'][$plugin_name] = $plugin['pages'];
		}
		$settings->plugin_cache = $cache;
	} else{
		return false;
	}
}
$hooks = array();
foreach($settings->plugin_cache['hook_cache'] as $hook){
	$hooks[$hook['hook']][] = $hook + array("t" => "load");
}

function call_hook($hook_name, $args = array()){
	global $hooks;
	if(is_array($hooks[$hook_name])){
		foreach($hooks[$hook_name] as $f){
			if($f['t'] == "load"){
				@include_once("../plugins/${f['plugin_name']}/${f['file']}");
				call_user_func_array($f['function'], $args);
			} else{
				call_user_func_array($f, $args);
			}
		}
	}
}

function hook_onto($hook_name, $function){
	global $hooks;
	$key = $function; // no duplicates please!
	if(is_array($function))
		$key = get_class($function[0]) . "." . $function[1];
	$hooks[$hook_name][$key] = $function;
}
