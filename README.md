# 🛒 Ecommerce site built using pure PHP & vanilla JavaScript

This project is an ecommerce wesbite built without any frameworks. My goal was to learn how to code a functional application to learn fundamentals of OOP and the MVC architecture while setting up a somewhat modern development environment.

Feel free to read, use, fork, comment, critique or help in any way.

## ⚒️ This project was built using:

-   PHP7
-   JavaScript ES6
-   Composer packages like:
    -   philo/laravel-blade as the template engine
    -   PHPMailer: to send emails
-   Webpack & Babel
-   Sass

## ⚙️Installation

If you want to test this project on your local machine, you have to follow these steps:

1.  **Download the code**
    You can either download the .zip file or run `git clone https://github.com/crjoseabraham/shoppingcart.git`

2.  **Install dependencies**
    Then, install all dependencies by running:
    `npm install` and `composer install`

3.  **Import database**
    Go to your database manager (phpmyadmin, heidiSQL or whatever) and import the .sql file located in `resources/data/`. The `CREATE DATABASE` command is included already.

4.  **Update credentials !important**
    In order to get everything working you may need to do some changes in the file `src/Config/constants.php`

    ````
        define('URLROOT', 'http://localhost/shoppingcart');
        define('BRAND_NAME', 'About the Fit');
        define('BRAND_EMAIL', '');
        define('BRAND_EMAIL_PASS', '');

        // Database config values
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'shoppingcart');
        ```

        And the project base URL in `resources/scripts/CartUI.js` which is set up for localhost.

        An small thing you may want to change or even delete is the timezone I set in [public/index.php](https://github.com/crjoseabraham/shoppingcart/blob/version-2.0/public/index.php) because I used my timezone

        `date_default_timezone_set('America/Caracas');`
    ````

## 📝 ToDo List:

-   [ ] Implement checkout with PayPal/Stripe API
-   [ ] User reviews and product rating
-   [ ] Deployment

## 🏆 Goals achieved

-   [x] Learn how to work with the OOP paradigm
-   [x] Understand how to apply the MVC architecture and its hows and whys
-   [x] How to work with sessions and cookies in PHP
-   [x] Implement user authentication (logging in, logging out, update user's password, recover password function, hide/show content for non logged in users.
-   [x] Work with third party libraries
-   [x] Practice modern JavaScript and transpile it using Webpack and Babel
-   [x] In general: work with PHP, JS, SASS and tie it all together to have a functional application

### Author

José Abraham Castillo
