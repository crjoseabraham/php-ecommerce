<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
$router->get('item/{id}/details', 'ViewLoaders@showItemDetails');

$router->post('user-exists', 'Users@userExists');
$router->post('signup', 'Users@register');