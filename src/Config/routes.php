<?php
$router->get('', 'View@layouts/home');
$router->get('login_form', 'View@components/login_form');
$router->get('register_form', 'View@components/register_form');
$router->get('item/{id}/details', 'View@components/item_details');