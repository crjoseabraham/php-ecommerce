<?php 
$router->get('shoppingcart/', 'Website@updateData');
$router->post('shoppingcart/item/add', 'Article@addItem');
$router->post('shoppingcart/item/delete', 'Article@deleteItem');
$router->post('shoppingcart/rate', 'Rating@storeRaiting');