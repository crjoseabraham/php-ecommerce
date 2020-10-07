<?php
/**
 * Get current URI removing the first part
* Removing the first part so it'll be left with "controller/action"
* @return string $uri  processed URI
*/
function getURI() : string {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uri = explode('/', $uri);
    array_shift($uri);

    return implode('/', $uri);
}

/**
* Get HTTP Method
* @return string   GET or POST
*/
function getMethod() : string {
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * Redirect method
 * @param  string $file Path to desired page
 */
function redirect(string $file) : void {
    header('Location: ' . $_ENV['URLROOT'] . $file, true, 303);
    exit;
}