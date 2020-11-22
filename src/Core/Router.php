<?php
namespace App\Core;

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];
    private $params = [];

    /**
     * Used to load routes.php file
     * @param string $file  Path to the routes.php file
     * @return Router       Instance of Router class
     */
    public static function loadRoutes(string $file) : Router {
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
    public function get(string $uri, string $controller) : void {
        $this->routes['GET'][$this->convertToRegex($uri)] = array_combine(['controller', 'method'], explode('@', $controller));
    }

    /**
     * Add a POST route
     * @param string $uri         URI to desired controller
     * @param string $controller  Respective controller and action for the URI
     * @return void
     */
    public function post(string $uri, string $controller) : void {
        $this->routes['POST'][$this->convertToRegex($uri)] = array_combine(['controller', 'method'], explode('@', $controller));
    }

    /**
     * Convert URI to a regular expression in order to have a flexible router for some routes that have an parameters like {id} or {token}
     * @param string $uri   URI
     * @return string $uri  Converted URI
     */
    private function convertToRegex(string $uri) : string {
        // Escape forward slashes
        $uri = \preg_replace('/\//', '\\/', $uri);

        // Convert parameter for item ID, user ID, etc
        $uri = preg_replace('/\{(id||item||user)\}/', '(?P<\1>\d+)', $uri);

        // Convert parameter {token}
        $uri = preg_replace('/\{(token)\}/', '(?P<\1>[\da-f]+)', $uri);

        // Convert parameter {category}
        $uri = preg_replace('/\{(category)\}/', '(?P<\1>[a-z]+)', $uri);

        // Add start and end delimeter
        $uri = '/^' . $uri . '$/i';

        return $uri;
    }

    /**
     * Match URI and method with respective controller and action
     * Call controller
     * @param string $uri         URI to desired controller
     * @param string $requestType HTTP method (GET or POST)
     * @return void
     */
    public function redirect() : void {
        $this->setCurrentRoute(getURI(), getMethod());
        $controller = array_shift($this->params);

        try {
            if (class_exists($controller)) {
                $controller_object = new $controller();
                $action = array_shift($this->params);
                $params = !empty($this->params) ? $this->params : null;

                if (is_null($params))
                        $controller_object->$action();
                    else
                        $controller_object->$action($params);
            } else
                throw new \Exception("Controller or method not found", 404);
        } catch (\Exception $message) {
            die($message);
        }
    }

    /**
     * Set the current route values (controller and params, if there are any) in $this->params
     *
     * @param string $uri           Current URI
     * @param string $requestType   HTTP Method
     * @return void
     */
    private function setCurrentRoute($uri, $requestType) : void {
        foreach ($this->routes[$requestType] as $route => $params) {
            if (preg_match($route, $uri, $matches)) {
                // Set namespace
                $this->params['controller'] = '\App\Controller\\' . $params['controller'];
                // Set method
                $this->params['method'] = $params['method'];

                foreach ($matches as $key => $match) {
                if (is_string($key))
                    $this->params[$key] = $match;
                }
            }
        }
    }
}