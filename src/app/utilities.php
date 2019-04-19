<?php 
//------------------------
//  Utility functions
//------------------------

/**
  * Get current URI removing the first part
  * Example: by default it would look like this "shoppingcart/controller/action"
  * Removing the first part it'll be "controller/action"
  * @return string $uri  processed URI
  */
function getURI() : string
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
function getMethod() : string
{
  return $_SERVER['REQUEST_METHOD'];
}

/**
* Load a view
* @param string $file  Path to file
* @param array  $data  Optional data that the view may require
* @return void
*/
function renderView($file, $data = []) : void
{
  // Specify our Twig templates location
  $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/views');
  // Instantiate Twig
  $twig = new \Twig_Environment($loader, ['debug' => true]);
  $twig->addExtension(new \Twig\Extension\DebugExtension());
  // If there's a session running, get user data
  if (isset($_SESSION['user']))
  {
    $twig->addGlobal('current_user', ['userSession' => \Model\Session::getUser(), 'userCart' => \Model\Cart::getCartItems()]);
  }

  echo $twig->render($file, ['data' => $data]);
}

/**
 * Redirect method
 * @param  string $file Path to desired page
 * @return void 
 */
function redirect($file)
{
  header('Location: ' . URLROOT . $file, true, 303);
  exit;
}