# Shopping cart app with PHP & JS ES6

This is a basic shopping cart made without frameworks, my goal was to learn how to code a functional app with the fundamentals of OOP with the MVC architecture and also how to setup a modern development environment.

Feel free to read, use, fork, comment, critique or help in any way.

### This project was built using:

 - PHP7
 - JavaScript ES6
 - Composer packages like:
	 - Twig: template engine
	 - mPDF: a .pdf files generator
	 - PHPMailer: to send emails
 - Webpack
 - Babel
 - Sass

## Installation

If you want to test this project on your local machine, you have to follow these steps:

 1. **Download the code**
 You can whether download the .zip file or run `git clone https://github.com/crjoseabraham/shoppingcart.git`
 
 2. **Install dependencies**
 Then, install all dependencies by running: 
 `composer install`
 and 
 `npm install`

3. **Import database**
Go to your database manager (phpmyadmin, heidiSQL or whatever) and import the .sql file that's located in the `data` folder. The `CREATE DATABASE` command is included already.

4. **Update credentials !important**
In order to get everything working you may need to do some changes in the file that's located in `src / app / import / constants.php` like in these lines:
	```
	define('URLROOT', 'http://localhost/shoppingcart');
	
	// Database config values
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'shoppingcart');	
	
	// Email credentials
	define('EMAIL_HOST', '');
	define('EMAIL_USER', '');
	define('EMAIL_NAME', '');
	define('EMAIL_PASS', '');
	```
	Another thing you may want to change or even delete is the timezone I set in `public / index.php` because I used my timezone
	
	`date_default_timezone_set('America/Caracas');`
	
## Tester account

If you feel lazy and don't want to sign up, you can log in with a tester account that's in the database:

 - **Email:** tester@gmail.com
 - **Password:** abc123

~~At least it's not user: admin and pass: admin~~

## Version 1.0

There's a much simpler version of this project. Without dependencies and more vanilla, you can check it out in the branch [version 1.0](https://github.com/crjoseabraham/shoppingcart/tree/master)

## Project structure
```
shoppingcart/
    assets/		# Uncompiled and raw SCSS and JavaScript code
    data/		# SQL database file
    node_modules/	# Node.js front-end dependencies
    public/		# Publicly accessible files
        css/		# Final and compiled styles
        img/		# Images used
        js/		# Final and compiled scripts
        index.php	# Application start point
    src/		# PHP source code
        app/		# Database and Router classes
            import/	# Essentials files imported at the beginning:
		        # config constants, routes, utility functions
        controllers/	# Controller classes
        models/		# Model classes
        views/		# HTML templates
    vendor/		# Composer files and 3rd party libraries
    .gitignore		# Files and folders to be ignored by git commands
    .htaccess		# To redirect the start point to public/ folder
    composer.json	# Composer dependency file
    composer.lock	# Composer lockfile
    package-lock.json	# Dependency lockfile
    package.json	# NPM dependency file
    webpack.config.js	# Webpack configuration file
```

## Goals achieved

 - [x] Learn how to work with the OOP paradigm
 - [x] Understand how to apply the MVC architecture and it's hows and whys
 - [x] How to work with sessions and cookies in PHP
 - [x] Implement user authentication (logging in, logging out, update user's password, recover password function, hide/show content for non logged in users.
 - [x] Work with third party libraries
 - [x] Generate PDF reports
 - [x] Practice modern JavaScript and transpile it using Webpack and Babel
 - [x] In general: work with PHP, JS, SASS and tie it all together to have a functional application

## Author
José Abraham Castillo
