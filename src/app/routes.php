<?php
$router->get('', 'Pages@index');
$router->get('home', 'Pages@index');
$router->get('store', 'Pages@store');
$router->get('login', 'Pages@login');
$router->get('register', 'Pages@register');
$router->get('purchase-details', 'Pages@purchaseDetails');
$router->get('logout', 'Auth@logout');
$router->get('remove-item/{item}', 'Carts@remove');

$router->post('login', 'Auth@login');
$router->post('register', 'Auth@register');
$router->post('process-payment', 'Payments@processPayment');
$router->post('add-item/{item}', 'Carts@add');
$router->post('rate-product/{item}', 'Products@rateProduct');