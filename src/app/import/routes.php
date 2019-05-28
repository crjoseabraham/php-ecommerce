<?php
$router->get('', 'Pages@index');                                  #DONE ✔
$router->get('home', 'Pages@index');                              #DONE ✔
$router->get('store', 'Pages@store');                             #DONE ✔
$router->get('login', 'Pages@login');                             #DONE ✔
$router->get('register', 'Pages@register');                       #DONE ✔
$router->get('purchase-details', 'Pages@purchaseDetails');        #DONE ✔
$router->get('profile', 'Pages@profile');                         #DONE ✔
// @todo: Change to post ->
$router->get('logout', 'Auth@logout');                            #DONE ✔
$router->get('remove-item/{item}', 'Carts@remove');               #DONE ✔
$router->get('receipt/{item}', 'Receipts@print');                 #DONE ✔
$router->get('confirm-payment', 'Pages@confirmPayment');          #DONE ✔


$router->post('login', 'Auth@login');                             #DONE ✔
$router->post('register', 'Auth@register');                       #DONE ✔
$router->post('process-payment', 'Payments@processPayment');      #DONE ✔
$router->post('add-item/{item}', 'Carts@add');                    #DONE ✔
$router->post('rate-product/{item}', 'Products@rateProduct');     #DONE ✔
$router->post('update-info', 'Users@updateInfo');                 #DONE ✔
$router->post('delete-account', 'Users@deleteAccount');           #DONE ✔