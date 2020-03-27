<?php
$router->get('', 'View@home');
$router->get('add-item/{id}', 'View@add');