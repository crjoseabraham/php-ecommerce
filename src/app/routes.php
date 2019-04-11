<?php
$router->get('', 'Pages@index');
$router->get('home', 'Pages@index');
$router->get('store', 'Pages@store');
$router->get('login', 'Pages@login');
$router->get('register', 'Pages@register');
$router->get('purchase-details', 'Pages@purchaseDetails');

$router->post('login', 'Pages@login');
$router->post('logout', 'Pages@logout');
$router->post('register', 'Pages@register');
$router->post('process-payment', 'Users@processPayment');
$router->post('add-item/{item}', 'Products@add');
$router->post('remove-item/{item}', 'Products@remove');
$router->post('rate-product/{item}', 'Products@rateProduct');