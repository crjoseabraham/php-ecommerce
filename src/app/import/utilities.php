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
* @param mixed  $data  Optional data that the view may require
*/
function renderView(string $file, $data = []) : void
{
  echo getTemplate($file, $data);
}

/**
* Get an .html template
* @param string $file  Path to file
* @param mixed  $data  Optional data that the view may require
*/
function getTemplate(string $file, $data = [])
{
  $twig = null;

  if ($twig === null)
  {
    // Specify our Twig templates location.
    $loader = new \Twig_Loader_Filesystem(dirname(dirname(__DIR__)) . '/views');
    // Instantiate Twig
    $twig = new \Twig_Environment($loader, ['debug' => true]);
    // Check if user is logged in or there's a cookie to remember a session. Also flash messages
    $twig->addGlobal('current_user', \Model\Session::getUser());
    $twig->addGlobal('flash_message', getFlashNotification());
    // If there's a session running, get user data and corresponding cart
    if (isset($_SESSION['user_id']))
    {
      $twig->addGlobal('user_cart', \Controller\Carts::getCartItems());
      $twig->addGlobal('subtotal', \Controller\Carts::getCartTotal());
      $twig->addGlobal('balance', $_SESSION['cash']);
    }
  }

  return $twig->render($file, ['data' => $data]);
}

/**
 * Redirect method
 * @param  string $file Path to desired page
 */
function redirect(string $file) : void
{
  header('Location: ' . URLROOT . $file, true, 303);
  exit;
}

/**
 * Set flash message
 * @param         $message Message sent to the user
 * @param  string $type    Success message, warning, error, etc.
 */
function flash($message, string $type = SUCCESS) : void
{
  if (!isset($_SESSION['flash_notification']))
  {
    $_SESSION['flash_notification'] = ['message' => $message, 'type' => $type];
  }
}

/**
 * Get flash message
 * @return  array Array containing message body and type
 */
function getFlashNotification()
{
  if (isset($_SESSION['flash_notification']))
  {
    $message = $_SESSION['flash_notification'];
    unset($_SESSION['flash_notification']);

    return $message;
  }
}