<?php 
/**
 * Router class
 * Gets URL and redirects to a view
 */
class Router
{
	private $controller;
	private $action;
	private $params = [];

	public function __construct()
	{
		$this->checkURI($this->getURI());
		# Require the controller file, instantiate it and then call required method
		require_once '../app/controllers/'. $this->controller . '.php';
		$this->controller = new $this->controller;
		call_user_func_array([$this->controller, $this->action], [$this->params]);
	}

	/**
   * Fetch the request URI.
   * @return string
   */
  private function getURI() : string
  {
      return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
  }

  /**
   * Fetch the request method.
   * @return string
   
  private function getMethod() : string
  {
      return $_SERVER['REQUEST_METHOD'];
  }
  */

  /**
   * Check if controller and method passed actually exists
   * @param string The current URI
   * @param string The request method (GET or POST)
   * @return void
   */
  private function checkURI(string $uri) : void
  {
  	$uri = explode('/', $uri);
  	array_shift($uri);

  	# Check if controller exists
  	if (isset($uri[0]) && file_exists('../app/controllers/' . ucwords($uri[0]) . '.php')) {
  		$this->controller = ucwords($uri[0]);
  		unset($uri[0]);
  	} else {
  	# If not then set default controller to "Pages" to redirect to index.php
  	# Read [NOTE] below
  		$this->controller = 'Pages';
  	}

  	# Check if method was passed and exists
  	if (isset($uri[1]) && method_exists($this->controller, $uri[1])) {
  		$this->action = $uri[1];
  		unset($uri[1]);
  	} else {
  	# --- [ NOTE ]: THIS IS ONLY FOR A VERY SMALL PROJECT LIKE THIS
  	# SINCE ALL THE POSSIBLE URLs FOR THIS PROJECT ARE "{controller}/{method}"
  	# IF YOU WRITE ONLY "{controller}/" IT WILL REDIRECT TO HOMEPAGE
  		$this->controller = 'Pages';
  		$this->action = 'home';
  	}

  	# Get params
  	$this->params = $uri ? array_values($uri) : [];
  }
}