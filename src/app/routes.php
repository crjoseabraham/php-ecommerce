<?php
$router->get('', 'Pages@index');
$router->get('about', 'Pages@about');
$router->get('login', 'Pages@login');
$router->get('register', 'Pages@register');
$router->get('purchase-details', 'Pages@purchaseDetails');

$router->post('login', 'Users@login');
$router->post('logout', 'Users@logout');
$router->post('register', 'Users@register');
$router->post('process-payment', 'Users@processPayment');
$router->post('add-item/{item}', 'Products@add');
$router->post('remove-item/{item}', 'Products@remove');
$router->post('rate-product/{item}', 'Products@rateProduct');