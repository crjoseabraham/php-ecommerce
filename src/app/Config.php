<?php
namespace App;

class Config
{
  public const URLROOT = 'http://localhost/shoppingcart';
  protected const DB_HOST = 'localhost';
  protected const DB_USER = 'root';
  protected const DB_PASS = '';
  protected const DB_NAME = 'shoppingcart';

  /**
   * Get current URI removing the first part
   * Example: by default it would look like this "shoppingcart/controller/action"
   * Removing the first part it'll be "controller/action"
   * @return string $uri  processed URI
   */
  public static function getURI() : string
  {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uri = explode('/', $uri);
    array_shift($uri);
    $uri = implode('/', $uri);

    return $uri;
  }

  /**
   * Get HTTP Method
   * @return string   GET or POST
   */
  public static function getMethod() : string
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Load a view
   * @param string $file  Path to file
   * @param array  $data  Optional data that the view may require
   * @return void
   */
  public static function renderView($file, $data = []) : void
  {
    // Specify our Twig templates location
    $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/views');
    // Instantiate Twig
    $twig = new \Twig_Environment($loader);

    echo $twig->render($file, ['data' => $data]);
  }
}