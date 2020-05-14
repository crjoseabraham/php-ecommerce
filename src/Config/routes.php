<?php
$router->get('', 'View@home');
$router->get('login_form', 'View@components/login_form');
$router->get('add-item/{id}', 'View@add');