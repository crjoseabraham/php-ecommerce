<?php 
define('URLROOT', 'http://localhost/shoppingcart');
define('SECRET_KEY', 'RYdC5cmDUbgglwwMLTUrcBzs6HXG5NBZ');

// Database config values
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shoppingcart');

// Flash message types
define('SUCCESS', 'success');
define('INFO', 'warning');
define('ERROR', 'danger');

// User authentication notifications
define('LOGIN_REQUIRED', 'You need to be logged in to do that');
define('LOGIN_ERROR', 'Email and password combination is wrong');
define('NAME_MISSING', 'Name is required');
define('EMAIL_INVALID', 'Invalid email');
define('EMAIL_EXISTS', 'Email address already exists');
define('PASSWORD_MATCH', 'Password must match confirmation');
define('PASSWORD_TOO_SHORT', 'Password must be at least 6 characters long');
define('PASSWORD_NEEDS_LETTER', 'Password needs at least one letter');
define('PASSWORD_NEEDS_NUMBER', 'Password needs at least one number');

// Cart notifications
define('ITEM_ADDED', 'Item added to your cart');
define('ITEM_REMOVED', 'Item removed from your cart');
define('ERROR_MESSAGE', 'Something went wrong. Please try again');
define('OVER_BUDGET', 'You don\'t have enough money for this purchase. Please remove some items');
define('PURCHASE_COMPLETED', 'Your order was processed successfully. You can get see the receipt in your profile page.');
define('VOTE_SUBMITTED', 'Your vote was submitted successfully');
define('VOTE_ERROR', 'Sorry but you can rate an item only once per session');

// User profile notifications
define('NO_CHANGES', 'No changes to make');
define('DATA_UPDATED', 'Your information was updated successfully');