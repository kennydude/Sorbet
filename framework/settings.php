<?php
// Settings framework

class Settings{
	public $settingsWorking = false;
	private $intSettings;
	
	public function __construct() {
		$file = @file_get_contents("../settings.json");
		if(!$file)
			return;
		$this->intSettings = json_decode($file, true);
		if(!$this->intSettings)
			return;
		$this->settingsWorking = true;
	}
	
	public function __get($key){
		return $this->intSettings[$key];
	}
	
	public function __set($key, $value){
		$this->intSettings[$key] = $value;
	}
	
	public static function prettyNames(){
		return array(
			"site_title" => "Site Title",
			"mysql_username" => "MySQL username",
			"mysql_password" => "MySQL password",
			"mysql_host" => "MySQL host",
			"mysql_database" => "MySQL database"
		);
	}
	
	public function getPrettyNames(){
		$r = array();
		foreach(Settings::prettyNames() as $key => $value){
			$r[$key] = array("name" => $value, "value" => $this->__get($key));
		}
		return $r;
	}
	
	public function to_array(){
		return $this->intSettings;
	}
}