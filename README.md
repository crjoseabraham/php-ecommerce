# 🛒 Ecommerce site built using pure PHP & vanilla JS

This project is an ecommerce wesbite built without any frameworks. My goal was to learn how to code a functional application to learn fundamentals of OOP and the MVC architecture while setting up a somewhat modern development environment.

## ⚒️ This project was built using:

-   PHP7
-   JavaScript ES6
-   Composer packages like:
    -   philo/laravel-blade as the template engine
    -   PHPMailer: to send emails
    -   Omnipay to handle payments through PayPal API
-   Webpack & Babel
-   Sass

## ⚙️Installation

If you want to test this project on your local machine, you have to follow these steps:

1.  **Download the code**
    You can either download the .zip file or run `git clone https://github.com/crjoseabraham/ecommerce-NoFramework.git`

2.  **Install dependencies**
    Then, install all dependencies by running:
    `npm install` and `composer install`

3.  **Import database**
    Go to your database manager and import the .sql file located in `resources/data/`. The `CREATE DATABASE` command is included already.

4.  **Update environment variables**
    Create a `.env` file and set the following variables:

    ```
        URLROOT
        SECRET_KEY
        ------------------
        DB_HOST
        DB_USER
        DB_PASS
        DB_NAME
        ------------------
        BRAND_EMAIL
        BRAND_EMAIL_PASS
        ------------------
        PAYPAL_EMAIL
        PAYPAL_USERNAME
        PAYPAL_PASSWORD
        PAYPAL_SIGNATURE
        PAYPAL_CLIENT_ID
        PAYPAL_SECRET
    ```

    And change the project base URL in [resources/scripts/CartUI.js](https://github.com/crjoseabraham/ecommerce-NoFramework/blob/master/resources/scripts/CartUI.js) which is set up for localhost
    **(lines 77 and 116)**.

    An small thing you may want to change or even delete is the timezone I set in [public/index.php](https://github.com/crjoseabraham/ecommerce-NoFramework/blob/master/dist/index.php) because I used my timezone

    `date_default_timezone_set('America/Caracas');`

## 🏆 Goals achieved

-   [x] Learn the principles of OOP and how to apply the MVC architecture
-   [x] How to work with sessions and cookies in PHP
-   [x] Implement user authentication (logging in, logging out, remember session, recover passwords, etc.).
-   [x] Work with third party libraries
-   [x] Practice modern JavaScript and transpile it using Webpack and Babel
-   [x] Basics of version control with Git (work with repos, commits, branching and merging).
-   [x] Set up PayPal sandbox

### Preview

![Project Preview](https://i.imgur.com/XA35ltf.jpg)
