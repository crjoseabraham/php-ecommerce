<?php
/*!
 * PHP Shopping cart
 *
 * An MVC application written with vanilla PHP, without libraries or frameworks
 *
 * @version 2.0
 * @author	José Abraham Castillo
 * @link	https://github.com/crjoseabraham/shoppingcart
 *
 * This project started as a challenge for a job interview where I had to create a very basic
 * shopping cart app with PHP applying Object Oriented Programming and Sessions.
 * [My goal]: To teach myself Object Oriented Programming (OOP), MVC architecture, routing & sessions.
 *
 * [UPDATE]
 * VERSION 2.0: I made new changes to this project (again) applying some modern concepts.
 * This is what's new in this version:
 * - Register GET and POST routes separately
 * - Regular Expressions (used for the router and for validations)
 * - Namespaces
 * - Prevent form resubmittion using the POST/Redirect/GET (PRG) Pattern
 * - Better session handler
 * - User managemente (Change/Recover password)
 * - Use of a template engine: Twig
 * - UI Improvements
 */

require dirname(__DIR__) . '/vendor/autoload.php';

App\Router::load(APPROOT . '/src/app/routes.php')->test();