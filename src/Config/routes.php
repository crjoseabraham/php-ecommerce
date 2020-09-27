<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
$router->get('forgotten-password', 'ViewLoaders@forgottenPassword');
$router->get('password/reset/{token}', 'Account\Passwords@validateResetLink');
$router->get('reset-password-form-{id}--{token}', 'ViewLoaders@resetPasswordForm');
$router->get('profile', 'ViewLoaders@profile');
$router->get('confirm-delete-account', 'ViewLoaders@deleteAccountForm');
$router->get('product_details.{item}', 'ViewLoaders@productDetails');
$router->get('get-cart', 'Merchandise\CartOperations@getJSON');

$router->post('signup', 'Account\Accounts@create');
$router->post('login', 'Account\Auth@login');
$router->post('logout', 'Account\Auth@logout');
$router->post('request-password-reset', 'Account\Passwords@requestReset');
$router->post('update-forgotten-password_{id}-{token}', 'Account\Passwords@updateForgotten');
$router->post('update-profile/basic', 'Account\Accounts@updateBasic');
$router->post('update-profile/password/{id}', 'Account\Passwords@change');
$router->post('delete-account', 'Account\Accounts@delete');
$router->post('add-to-cart.{item}', 'Merchandise\CartOperations@add');
$router->post('remove-item', 'Merchandise\CartOperations@remove');