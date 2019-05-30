<?php
$router->get('', 'Pages@index');
$router->get('home', 'Pages@index');
$router->get('store', 'Pages@store');
$router->get('login', 'Pages@login');
$router->get('register', 'Pages@register');
$router->get('purchase-details', 'Pages@purchaseDetails');
$router->get('profile', 'Pages@profile');

$router->post('login', 'Auth@login');
$router->post('logout', 'Auth@logout');
$router->post('register', 'Auth@register');
$router->post('add-item/{item}', 'Carts@add');
$router->post('remove-item/{item}', 'Carts@remove');
$router->post('confirm-payment', 'Pages@confirmPayment');
$router->post('process-payment', 'Payments@processPayment');
$router->post('receipt/{item}', 'Receipts@print');
$router->post('rate-product/{item}', 'Products@rateProduct');
$router->post('update-info', 'Users@updateInfo');
$router->post('delete-account', 'Users@deleteAccount');