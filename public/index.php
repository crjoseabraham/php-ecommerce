<?php
/*!
 * PHP Shopping cart
 *
 * An MVC application written with vanilla PHP, without libraries or frameworks
 *
 * @version 2.0
 * @author	José Abraham Castillo
 * @link	https://github.com/taniarascia/laconia
 *
 * This project started as a challenge for a job interview where I had to create a very basic
 * shopping cart app with PHP applying Object Oriented Programming and Sessions.
 * I fulfilled the requirements, but it was so bad coded that I felt the need to do a complete refactor
 * My goal was to teach myself the fundamentals of PHP, Object Oriented Programming (OOP), MVC architecture,
 * routing and PHP Sessions and how to work with all these together in order to make a real functional
 * web application without diving into frameworks or libraries yet (well, I used FPDF but don't tell anyone).
 */

require dirname(__DIR__) . '/app/config/constants.php';

spl_autoload_register(function ($className) {
	require_once APPROOT . "\\app\\config\\{$className}.php";
});

$init = new Router;