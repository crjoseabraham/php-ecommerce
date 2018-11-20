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
		$uri = $this->getURI();
    // Separate URL elements
    $uri = explode('/', $uri);
    array_shift($uri);

    // CHECK IF CONTROLLER EXISTS
    if (isset($uri[0]) && file_exists('../app/controllers/' . ucwords($uri[0]) . '.php')) {
      $this->controller = ucwords($uri[0]);
      unset($uri[0]);
    } else {
    // If not then redirect to home
      $this->controller = 'Products';
    }

    // Require controller class file
    require_once "../app/controllers/{$this->controller}.php";
    // Create new instance of class
    $this->controller = new $this->controller;

    // CHECK IF METHOD WAS PASSED AND EXISTS IN CLASS
		if (isset($uri[1]) && method_exists($this->controller, $uri[1])) {
      $this->action = $uri[1];
      unset($uri[1]);
    } else {
      $this->action = 'home';
    }

    // Get parameters (if passed)
    $this->params = $uri ? array_values($uri) : [];

    // Finally, call the desired method :)
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
}