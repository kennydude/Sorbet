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
		if(!$this->template)
			die("FATAL: Please set the Page->template");
		if($this->isDataPage)
			$data = $this->fetchData();
		if($_POST)
			$post_response = $this->postHandler();
		$this->onPreRender();
		if($_GET['format']){ // Output as JSON etc
			switch($_GET['format']){
				case "json":
					echo json_encode($data);
					break;
			}
		} else{
			$page_data = $this->page_data;
			$coredir = "../templates/"; // TODO: Have this to work properly
			if(!is_null($this->masterPage)){
				$template = "../templates/" . $this->template;
				require_once("../templates/" . $this->masterPage);
			} else
				require_once("../templates/". $this->template);
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