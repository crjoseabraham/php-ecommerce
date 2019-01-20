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
    $uri = explode('/', $uri);
    array_shift($uri);

    if (isset($uri[0]) && file_exists('../app/controllers/' . ucwords($uri[0]) . '.php')) {
      $this->controller = ucwords($uri[0]);
      unset($uri[0]);

      require_once "../app/controllers/{$this->controller}.php";
      $this->controller = new $this->controller;

      if (isset($uri[1]) && method_exists($this->controller, $uri[1])) {
        $this->action = $uri[1];
        unset($uri[1]);
      } else {
        echo "Page not found.";
        exit();
      }

      // Get parameters (if passed). $this->params = $uri ? array_values($uri) : [];

      call_user_func_array([$this->controller, $this->action], [$this->params]);
    } else {
      require_once APPROOT . '\\app\\views\\index.php';
      exit();
    }
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