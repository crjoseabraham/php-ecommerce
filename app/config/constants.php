<?php 
# Start session
session_start();
# Set session money
if (!isset($_SESSION['cash'])) $_SESSION['cash'] = 100;
# Database params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shoppingcart');
# App Root
define('APPROOT', dirname(dirname(__DIR__)));
# URL Root
define('URLROOT', 'http://localhost/shoppingcart');