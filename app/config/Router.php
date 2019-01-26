<?php
/**
 * Router class
 * Gets URL and redirects to a view
 */

class Router extends Controller
{
	private $controller;
	private $action;
	private $params = [];

	public function __construct()
	{
		parent::__construct();

		// 1. Get REQUEST URI
		$uri = $this->getURI();
		$uri = explode('/', $uri);
		array_shift($uri);

		// 2. Check if first part of URI (controller) actually exists, then require the file
		if (isset($uri[0]) && file_exists('../app/controllers/' . ucwords($uri[0]) . '.php')) {
			$this->controller = ucwords($uri[0]);
			unset($uri[0]);

			require_once "../app/controllers/{$this->controller}.php";
			$this->controller = new $this->controller;

		// 3. Check if second part of URI (method) actually exists. Otherwise, redirect home
			if (isset($uri[1]) && method_exists($this->controller, $uri[1])) {
				$this->action = $uri[1];
				unset($uri[1]);
			} else
					header('Location: ' . URLROOT . '/index/home');

			call_user_func_array([$this->controller, $this->action], [$this->params]);
		} else
				header('Location: ' . URLROOT . '/index/home');
	}

	/**
	 * Fetch the request URI.
	 * @return string REQUEST_URI e.g '/index/home'
	 */
	private function getURI() : string
	{
			return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	}
}