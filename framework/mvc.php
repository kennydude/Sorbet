<?php
// Model View Controller
// Rolled into one!
// This is magic! (kinda)

// This is called mvc.php, just so you know what it is.
// Really it's only VC, models are in use in other locations


/***
 * Core class for rendering.
 */
class Page{
	public $template; /**< The template to use. You need to override this */
	public $masterPage;
	public $apiOnly = false;
	
	public $page_data = array(); /**< Data that may be required by the template (to keep it common) */
	
	public $isDataPage = true; /**< If the page requires data. If not, don't implement fetchData */
	
	/**
	 * You need to implement fetching data here if required.
	 * If not, set isPageData to false
	 * It also needs to look okay for rendering as JSON
	 */
	public function fetchData(){
		die("FATAL: Please override Page->fetchData");
	}
	
	/**
	 * Override if you support POST
	 */
	public function postHandler(){ }
	
	/***
	 * Override if you want to do stuff before rendering.
	 */
	public function onPreRender(){}
	public function onPostRender(){}
	
	
	public function render(){
		global $settings, $page;
		if($this->isDataPage)
			$this->data = $this->fetchData();
			if($_POST || $_FILES)
				$post_response = $this->postHandler($this->data);
		else
			if($_POST || $_FILES)
				$post_response = $this->postHandler();
		$this->onPreRender();
		if($this->apiOnly == true)
			$_GET['format'] = "json";
		if($_GET['format']){ // Output as JSON etc
			switch($_GET['format']){
				case "json":
					header("Content-Type:application/json; charset=utf-8");
					if($post_response)
						$this->data = $post_response;
					if(is_object($this->data))
						echo json_encode($this->data->to_array());
					else
						echo json_encode($this->data);
					break;
			}
		} else{
			if($_SESSION['ADMIN_AUTH'] && $_GET['theme']){
				put_temp_message("You are viewing this page in Test Drive.");
			}
			$data = $this->data;
			$page_data = $this->page_data;
			$coredir = $settings->website_root."templates/"; // TODO: Have this to work properly
			$page = $this;
			function includeTemplate($template){
				global $page;
				if(!@include_once(getTemplate($template))){
					myErrorHandler(-3, "Template $template could not be found", "includeTemplate()", -1);
				}
			}
			/**
			 * Use for inside templates mainly to include other templates
			 * @param unknown_type $file
			 */
			function getTemplate($file){
				global $settings;
				if(is_string($file))
					$file = array($file);
				$templates = array();
				$theme = $settings->theme;
				if($_SESSION['ADMIN_AUTH'] && $_GET['theme']){ // TODO!: make $_SESSION a func
					$theme = $_GET['theme'];
				}
				foreach($file as $f){
					$templates[] = "../themes/$theme/$f";
					$templates[] = "../templates/$f";
					foreach($settings->activated_plugins as $plugin){
						$templates[] = "../plugins/$plugin/templates/$f";
					}
				}
				if($_GET['debug'] == "true" && $settings->debug == true)
					print_r($templates);
				foreach($templates as $template){
					if(file_exists($template))
						return $template;
				}
			}
			function resdir(){ // get current dir on server
				global $settings;
				$d = debug_backtrace();
				$d = $d[0]['file'];
				$d = str_replace($settings->file_root, "", $d);
				echo $settings->website_root . dirname($d);
			}
			if(!is_null($this->masterPage)){
				$template = getTemplate($this->template);
				require_once(getTemplate($this->masterPage));
			} else
				require_once(getTemplate($this->template));
		}
		$this->onPostRender();
	}
}

/**
 * Admin page. This is a special class
 * @author kennydude
 *
 */
class AdminPage extends Page{
	/**
	 * Set this to true if the page is used for logging in,
	 * this should only be in use at the "login.php" page.
	 * Basically, it disables the redirect to login.php
	 * @var bool
	 */
	public $loginPage = false;
	public $masterPage = "admin/main.php";
	public function onPreRender(){
		// TODO: OAuth
		if($_GET['oauth_token']){
			// do something
		}
		if(!$_SESSION['ADMIN_AUTH'] && $this->loginPage == false){
			header("Location: login.php"); exit;
		}
	}
}

/**
 * Created to show an error to the user
 * @author kennydude
 *
 */
class Error_Page extends Page{
	public function fetchData(){
		return array(
			"error" => $this->errorNo,
			"reason" => $this->reason
		);
	}
	public $errorNo = "666 NOT DEFINED";
	public function __construct($reason = ""){
		$this->reason = $reason;
		header("HTTP/1.1 " . $this->errorNo, true);
		header("Status: ". $this->errorNo, true);
		$this->render();
		exit();
	}
}

class Error_404 extends Error_Page{
	public $errorNo = "404 Not Found";
	public $template = "error/404.php";
}

class Error_503 extends Error_Page{
	public $errorNo = "503 Service Unavailable";
	public $template = "error/503.php";
}

class Error_Misconfig extends Error_503{
	public $template = "error/misconfig.php";
}
