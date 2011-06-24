<?php
// Sorbet Administrator
require "../framework/core.php";
require "../framework/auth.php";


class AdminSettingsPage extends AdminPage{
	public $masterPage = "admin/settings.php";
}

class AdminThemeSettingsPage extends AdminSettingsPage{
	public $template = "admin/theme-settings.php";
	function postHandler(){
		global $settings;
		$settings->theme = $_POST['theme'];
		$settings->save();
		put_message("Settings saved!");
		header("Location: settings.php?tab=themes");
		exit();
	}
	function fetchData(){
		global $settings;
		$themes = array();
		if ($handle = opendir('../themes/')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$themes[$file] = json_decode(file_get_contents("../themes/$file/info.json"), true);
				}
			}
			closedir($handle);
		}
		return array(
			"current_theme" => array_merge(array("codename" => $settings->theme), $themes[$settings->theme]),
			"themes" => $themes
		);
	}
}

class AdminPluginSettingsPage extends AdminSettingsPage{
	public $template = "admin/plugin-settings.php";
	function postHandler(){
		global $settings;
		require_once("plugins.php");
		clear_plugin_cache();
		unset($_POST['__']);
		foreach($_POST as $key => $value){
			if($value == "on"){
				activate_plugin($key);
			}
		}
		//$settings->activated_plugins = $ac;
		$settings->save();
		put_message("Settings saved!");
		header("Location: settings.php?tab=plugins");
		exit();
	}
	function fetchData(){
		global $settings;
		$plugins = array();
		$activated_plugins = $settings->activated_plugins;
		if ($handle = opendir('../plugins/')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$plugins[$file] = json_decode(file_get_contents("../plugins/$file/info.json"), true);
					$plugins[$file]['selected'] = (in_array($file, $activated_plugins));
				}
			}
			closedir($handle);
		}
		return $plugins;
	}
}

class AdminGeneralSettingsPage extends AdminSettingsPage{
	public $template = "admin/general-settings.php";
	
	function fetchData(){
		global $settings;
		return $settings->getPrettyNames();
	}
}

class AdminSocialSettingsPage extends AdminSettingsPage{
	public $template = "admin/social-settings.php";
	function postHandler(){
		global $settings;
		$settings->share_buttons = array_keys($_POST['share_buttons']);
		$settings->save();
		put_message("Settings saved!");
		header("Location: settings.php?tab=social");
		exit();
	}
	function fetchData(){
		global $settings;
		require("share_buttons.php");
		return array(
			"share_buttons" => array(
				"enabled" => $settings->share_buttons,
				"available" => array_keys($share_buttons)
			)
		);
	}
}

if(!$_GET['tab']){
	$_GET['tab'] = "main";
}

switch($_GET['tab']){
	case "social":
		$page = new AdminSocialSettingsPage();
		break;
	case "themes":
		$page = new AdminThemeSettingsPage();
		break;
	case "plugins":
		$page = new AdminPluginSettingsPage();
		break;
	default:
		$page = new AdminGeneralSettingsPage();
		break;
}
$page->render();
