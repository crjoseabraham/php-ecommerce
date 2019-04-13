<?php 
define('URLROOT', 'http://localhost/shoppingcart');

// Database config values
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shoppingcart');

// Messages
// Forms:
define('LOGIN_ERROR', 'Email and password combination is wrong');
define('NAME_MISSING', 'Name is required');
define('EMAIL_INVALID', 'Invalid email');
define('EMAIL_EXISTS', 'Email address already exists');
define('PASSWORD_MATCH', 'Password must match confirmation');
define('PASSWORD_TOO_SHORT', 'Password must be at least 6 characters long');
define('PASSWORD_NEEDS_LETTER', 'Password needs at least one letter');
define('PASSWORD_NEEDS_NUMBER', 'Password needs at least one number');

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
  $twig = new \Twig_Environment($loader);

  echo $twig->render($file, ['data' => $data]);
}