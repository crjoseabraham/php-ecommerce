<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
//$router->get('item/{item}/details', 'ViewLoaders@showItemDetails');
$router->get('forgotten-password', 'ViewLoaders@forgottenPassword');
$router->get('password/reset/{token}', 'Auth@validateResetPasswordToken');
$router->get('reset-password-form-{id}-{token}', 'ViewLoaders@resetPasswordForm');
$router->get('profile', 'ViewLoaders@profile');

$router->post('auth', 'Auth@auth');
$router->post('logout', 'Auth@logout');
$router->post('request-password-reset', 'Auth@requestPasswordReset');
$router->post('update-forgotten-password_{id}-{token}', 'Auth@updateForgottenPassword');
$router->post('update-profile/basic', 'Accounts@updateBasic');
$router->post('update-profile/password', 'Accounts@updatePassword');