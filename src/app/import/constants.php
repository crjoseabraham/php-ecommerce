<?php
define('URLROOT', 'http://localhost/shoppingcart');
define('SECRET_KEY', 'RYdC5cmDUbgglwwMLTUrcBzs6HXG5NBZ');

// Database config values
define('DB_HOST', 'localhost');
define('DB_USER', 'god');
define('DB_PASS', 'secret');
define('DB_NAME', 'shoppingcart');

// Email credentials
define('EMAIL_HOST', '');
define('EMAIL_USER', '');
define('EMAIL_NAME', '');
define('EMAIL_PASS', '');

// Flash message types
define('SUCCESS', 'success');
define('INFO', 'warning');
define('ERROR', 'danger');

// User authentication notifications
define('LOGIN_REQUIRED', 'You need to be logged in to perform that action');
define('LOGIN_ERROR', 'Email and password combination is wrong');
define('REGISTRATION_ERROR', 'Something went wrong with your registration');
define('NAME_MISSING', 'Name is required');
define('NAME_INVALID', 'Name can contain only letters');
define('EMAIL_INVALID', 'Invalid email');
define('EMAIL_EXISTS', 'Email address already exists');
define('EMAIL_DOESNT_EXISTS', 'The email address you entered is not in our database');
define('PASSWORDS_DONT_MATCH', 'Password must match confirmation');
define('PASSWORD_TOO_SHORT', 'Password must be at least 6 characters long');
define('PASSWORD_NEEDS_LETTER', 'Password needs at least one letter');
define('PASSWORD_NEEDS_NUMBER', 'Password needs at least one number');

// Product notifications
define('REVIEW_SUBMITTED', 'Your review was submitted successfully');
define('REVIEW_DELETED', 'Your review was deleted');

// Cart notifications
define('ITEM_ADDED', 'Item added to your cart');
define('ITEM_REMOVED', 'Item removed from your cart');
define('ERROR_MESSAGE', 'Something went wrong. Please try again');
define('OVER_BUDGET', 'You don\'t have enough money for this purchase. Please remove some items');
define('PURCHASE_COMPLETED', 'Your order was processed successfully. You can download the receipt in your profile page.');
define('VOTE_SUBMITTED', 'Your vote was submitted successfully');
define('VOTE_ERROR', 'Sorry but you can rate an item only once per session');

// User profile notifications
define('NO_CHANGES', 'No changes to make');
define('DATA_UPDATED', 'Your information was updated successfully');
define('RECOVER_PASSWORD_EMAIL', 'We sent you an email to help you recover your password');
define('RECOVER_TOKEN_EXPIRED', 'Sorry but the link for recovering your password has expired. Please get a new one by clicking the "Forgot your password?" option');