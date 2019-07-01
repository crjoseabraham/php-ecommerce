<?php
$router->get('', 'Pages@index');
$router->get('menu', 'Pages@menu');
$router->get('login', 'Pages@login');
$router->get('register', 'Pages@register');
$router->get('recover-password', 'Pages@recoverPasswordForm');
$router->get('update-basic', 'Pages@updateBasicInfoForm');
$router->get('update-password', 'Pages@updatePasswordForm');
$router->get('logout', 'Auth@logout');
$router->get('cart', 'Pages@loadCart');
$router->get('add-item/{item}', 'Pages@addItemForm');
$router->get('auth', 'Auth@checkSession');
$router->get('profile', 'Pages@profile');
$router->get('deactivate', 'Pages@deleteAccount');

// $router->get('purchase-details', 'Pages@purchaseDetails');
// $router->get('profile', 'Pages@profile');
// $router->get('forgot-password', 'Pages@forgottenPassword');
// $router->get('email-sent', 'Pages@emailSent');
// $router->get('password-reset/{token}', 'Auth@verifyResetPasswordToken');

$router->post('login', 'Auth@login');
$router->post('register', 'Auth@register');
$router->post('update-info/basic', 'Users@updateInfo');
$router->post('update-info/password', 'Users@updatePassword');
$router->post('add-item/{item}', 'Carts@add');
$router->post('remove-item/{item}', 'Carts@remove');
$router->post('process-payment', 'Payments@processPayment');
$router->post('receipt/{item}', 'Receipts@print');
$router->post('delete-account', 'Users@deleteAccount');



// $router->post('recover-password', 'Auth@recoverPassword');
// $router->post('password-reset/{token}', 'Auth@resetPasswordForm');
// $router->post('remove-item/{item}', 'Carts@remove');
// $router->post('confirm-payment', 'Pages@confirmPayment');
// $router->post('process-payment', 'Payments@processPayment');
// $router->post('receipt/{item}', 'Receipts@print');
// $router->post('rate-product/{item}', 'Products@rateProduct');
// $router->post('update-info', 'Users@updateInfo');
// $router->post('delete-account', 'Users@deleteAccount');