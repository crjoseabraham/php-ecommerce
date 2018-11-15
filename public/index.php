<?php
//require dirname(__DIR__) . '\\config\\routes.php';
require dirname(__DIR__) . '\\app\\Router.php';

spl_autoload_register(function ($nombre_clase) {
    require dirname(__DIR__) . '\\app\\controllers\\'. $nombre_clase . '.php';
});

$init = new Router;