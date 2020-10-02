<?php
/*!
 * An MVC application written with pure PHP, and JavaScript ES6
 *
 * @version 2.0
 * @author	José Abraham Castillo
 * @link	https://github.com/crjoseabraham/shoppingcart
 */
date_default_timezone_set('America/Caracas');
session_start();

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

App\Core\Router::loadRoutes(dirname(__DIR__) . '/src/Config/routes.php')->redirect();