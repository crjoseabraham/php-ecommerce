<?php
$router->get('', 'ViewLoaders@homepage');
$router->get('login_form', 'ViewLoaders@loginFormView');
$router->get('register_form', 'ViewLoaders@signUpFormView');
$router->get('item/{id}/details', 'ViewLoaders@showItemDetails');
$router->get('start-session/user/{id}', 'Sessions@startNew');

$router->post('signup', 'Auth@signUp');
$router->post('logout', 'Sessions@logOut');