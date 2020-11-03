<?php
define('BRAND_NAME', 'About the Fit');
// Flash message types
define('SUCCESS', 'success');
define('INFO', 'info');
define('ERROR', 'danger');
// Generic error message
define('ERROR_MESSAGE', 'Something went wrong. Please try again');
define('NOT_ALLOWED', 'You\'re not allowed to access that page');
// User authentication notifications
define('LOGIN_REQUIRED', 'You need to be logged in to perform that action');
define('LOGIN_ERROR', 'Email and password combination is wrong');
define('REGISTRATION_ERROR', 'Something went wrong with your registration');
// Form fields validation errors
define('INVALID_NAME', 'Name can only contain letters and spaces and must be at least 2 characters long');
define('INVALID_EMAIL', 'Invalid email address');
define('INVALID_PASS', 'Password needs at least: 4 characters, 1 uppercase letter, 1 lowercase letter, 1 number');
define('EMAIL_TAKEN', 'This email is already registered');
define('EMAIL_DOESNT_EXISTS', 'The email address you entered is not in our database');
define('PASS_MATCH_ERR', 'Password must match confirmation');
define('LOGIN_PASSW_ERROR', 'The password you entered doesn\'t meet our password requirements. Which means it\'s probably incorrect.');
// User profile notifications
define('NEW_USER', 'Your registration is complete. Welcome and enjoy!');
define('USER_404', 'We could\'nt find any user with the data provided');
define('NO_CHANGES', 'No changes to make');
define('DATA_UPDATED', 'Your information was updated successfully');
define('RECOVER_PASSWORD_EMAIL', 'We sent you an email with a link to recover your password');
define('RECOVER_TOKEN_EXPIRED', 'It seems like the link to recover your password has expired. Please ask for a new one in "Forgot my password"');
// Cart notifications
define('QUANTITY_ERROR', 'Quantity must be an integer number between 1 and 20');
define('SIZE_ERROR', 'It seems like you entered an invalid size');
define('ITEM_ADDED', 'Item added to your cart');
// Purchase notifications
define('PURCHASE_COMPLETED', 'Your payment was successfully completed. We emailed you the details of your purchase ♥');
define('PURCHASE_CANCELLED', 'Operation cancelled by user');
define('PURCHASE_PROFILEMSG', 'You can access to any of your transactions in the "Profile" page');