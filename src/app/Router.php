<?php
namespace App;

class Router
{
  private $routes = [
    'GET' => [],
    'POST' => []
  ];
  private $params = [];

  /**
   * Load routes.php file
   * @param string $file  Path to the routes.php file
   * @return Router       Instance of Router class
   */
  public static function load(string $file) : Router
  {
    $router = new self;

    require_once $file;

    return $router;
  }
  
  /**
   * Add a GET route
   * @param string $uri         URI to desired controller
   * @param string $controller  Respective controller and action for the URI
   * @return void
   */
  public function get(string $uri, string $controller) : void
  {
    $this->routes['GET'][$this->convertToRegex($uri)] = $controller;
  }

  /**
   * Add a POST route
   * @param string $uri         URI to desired controller
   * @param string $controller  Respective controller and action for the URI
   * @return void
   */
  public function post(string $uri, string $controller) : void
  {
    $this->routes['POST'][$this->convertToRegex($uri)] = $controller;
  }

  /**
   * Match URI and method with respective controller and action
   * Call controller
   * @param string $uri         URI to desired controller
   * @param string $requestType HTTP method (GET or POST)
   * @return void
   */
  public function redirect($uri, $requestType) : void
  {
    // Store parameters 'controller' and 'item' (if exists)
    foreach ($this->routes[$requestType] as $route => $params) 
    {
      if (preg_match($route, $uri, $matches))
      {
        $this->params['controller'] = '\Controller\\' . $params;
        
        foreach ($matches as $key => $match) 
        {
          if (is_string($key)) 
            $this->params[$key] = $match;
        }
      }
    }

    if(empty($this->params) || !$this->classAndMethodExists(...explode('@', $this->params['controller'])))
    {
      die('Page not found.');
    }

    call_user_func_array(explode('@', $this->params['controller']), [array_pop($this->params)]);
  }

  //---------------------------------------------
  //              PRIVATE METHODS
  //---------------------------------------------
  // Utilities for other methods in this class

  /**
   * Convert URI to a regular expression in order to have a flexible router for some routes that
   * have an parameters like {id} or {item}
   * @param string $uri   URI
   * @return string $uri  Converted URI
   */
  private function convertToRegex(string $uri) : string
  {
    // Escape forward slashes
    $uri = \preg_replace('/\//', '\\/', $uri);

    // Convert parameter {item}
    $uri = preg_replace('/\{(item)\}/', '(?P<\1>\d+)', $uri);

    // Convert parameter {token}
    $uri = preg_replace('/\{(token)\}/', '(?P<\1>[\da-f]+)', $uri);

    // Add start and end delimeter
    $uri = '/^' . $uri . '$/i';

    return $uri;
  }

  /**
   * Check if controller and method exist before call
   * @param string $class   Controller
   * @param string $method  Function
   * @return boolean        True if both exist, false if not
   */
  private function classAndMethodExists($class, $method) : bool
  {
    if (\class_exists($class)) 
    {
      if (\method_exists($class, $method)) 
        return true;
    }

    return false;
  }
}