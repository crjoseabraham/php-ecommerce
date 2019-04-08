<?php
namespace App;

class Router
{
  private $routes = [
    'GET' => [],
    'POST' => []
  ];

  public function getRoutes()
  {
    echo "<pre style='font-size:16px;'>";
    var_dump($this->routes);
  }

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
    $this->routes['GET'][$uri] = $controller;
  }

  /**
   * Add a POST route
   * @param string $uri         URI to desired controller
   * @param string $controller  Respective controller and action for the URI
   * @return void
   */
  public function post(string $uri, string $controller) : void
  {
    $this->routes['POST'][$uri] = $controller;
  }




  // TEST TWIG TEMPLATE ENGINE
  public function test()
  {
    $products = [
        'title' => 'Twig Test',
        'products' => [
          [
            'name'          => 'Notebook',
            'description'   => 'Core i7',
            'value'         =>  800.00,
            'date_register' => '2017-06-22',
          ],
          [
            'name'          => 'Mouse',
            'description'   => 'Razer',
            'value'         =>  125.00,
            'date_register' => '2017-10-25',
          ],
          [
            'name'          => 'Keyboard',
            'description'   => 'Mechanical Keyboard',
            'value'         =>  250.00,
            'date_register' => '2017-06-23',
          ]
        ]
    ];
    renderView('index.html', $products);
  }
}