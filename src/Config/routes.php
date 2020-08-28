<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
$router->get('item/{item}/details', 'ViewLoaders@showItemDetails');
$router->get('forgotten-password', 'ViewLoaders@forgottenPassword');

$router->post('auth', 'Auth@auth');
$router->post('logout', 'Auth@logout');