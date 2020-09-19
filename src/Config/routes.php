<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
$router->get('forgotten-password', 'ViewLoaders@forgottenPassword');
$router->get('password/reset/{token}', 'Auth@validateResetPasswordToken');
$router->get('reset-password-form-{id}-{token}', 'ViewLoaders@resetPasswordForm');
$router->get('profile', 'ViewLoaders@profile');
$router->get('confirm-delete-account', 'ViewLoaders@deleteAccountForm');
$router->get('product_details.{item}', 'ViewLoaders@productDetails');

$router->post('auth', 'Auth@auth');
$router->post('logout', 'Auth@logout');
$router->post('request-password-reset', 'Auth@requestPasswordReset');
$router->post('update-forgotten-password_{id}-{token}', 'Auth@updateForgottenPassword');
$router->post('update-profile/basic', 'Accounts@updateBasic');
$router->post('update-profile/password', 'Accounts@updatePassword');
$router->post('delete-account', 'Accounts@delete');
$router->post('add-to-cart.{item}', 'Products@validateAddingForm');
$router->post('remove-item', 'Products@removeFromCart');