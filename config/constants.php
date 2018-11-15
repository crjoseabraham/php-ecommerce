<?php 
# Database params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'mytodoapp');
# App Root
define('APPROOT', dirname(dirname(__DIR__)));
# URL Root
define('URLROOT', 'https://localhost/traversymvc');
# Site Name
define('SITENAME', 'TraversyMVC');

echo "approot ". APPROOT;
echo "urlroot ". URLROOT;