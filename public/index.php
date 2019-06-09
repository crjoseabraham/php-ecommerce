<?php
/*!
 * An MVC application written with vanilla PHP, and JavaScript ES6
 *
 * @version 2.0
 * @author	José Abraham Castillo
 * @link	https://github.com/crjoseabraham/shoppingcart
 */
date_default_timezone_set('America/Caracas');

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

App\Router::load(dirname(__DIR__) . '/src/app/import/routes.php')->redirect(getURI(), getMethod());