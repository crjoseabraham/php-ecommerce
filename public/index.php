<?php
require dirname(__DIR__) . '/app/config/constants.php';

spl_autoload_register(function ($className) {
	require_once APPROOT . "\\app\\config\\{$className}.php";
});

$init = new Router;