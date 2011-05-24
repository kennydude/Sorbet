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
			"current_theme" => array_merge(array("codename" => $settings->theme),
												$themes[$settings->theme]),
			"themes" => $themes
		);
	}
}

class AdminGeneralSettingsPage extends AdminSettingsPage{
	public $template = "admin/general-settings.php";
	
	function fetchData(){
		global $settings;
		return $settings->getPrettyNames();
	}
}

switch($_GET['tab']){
	case "themes":
		$page = new AdminThemeSettingsPage();
		break;
	default:
		$page = new AdminGeneralSettingsPage();
		break;
}
$page->render();