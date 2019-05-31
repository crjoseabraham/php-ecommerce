<?php
namespace Controller;

use \Model\Session;

/**
 * Pages Controller
 * Only displays the views for the GET requests
 */
class Pages
{
  /**
   * Displays main page
   */
  public function index() : void
  {
    renderView('index.html');
  }

  /**
   * Displays 'Store' page with all products
   */
  public function store() : void
  {
    renderView('store.html', Products::getAllProducts());
  }

  /**
   * Displays login form
   */
  public function login() : void
  {
    // Hide login page if user is already logged in
    if (Session::getUser())
      redirect('/store');
    else
      renderView('login.html');
  }

  /**
   * Displays register form
   */
  public function register() : void
  {
    // Hide register page if user is already logged in
    if (Session::getUser())
      redirect('/store');
    else
      renderView('register.html');
  }

  /**
   * Displays profile page
   */
  public function profile() : void
  {
    if (Session::getUser())
      renderView('profile.html', Payments::getUserOrders());
    else
      redirect('/home');
  }

  /**
   * Displays payment confirmation page
   */
  public function confirmPayment() : void
  {
    if (Session::getUser())
      renderView('confirm-payment.html', Products::getAllProducts());
    else
      redirect('/home');
  }

  /**
   * Forgotten password page
   */
  public function forgottenPassword()
  {
    Emails::send('zasaxux@airsport.top', 'Email test', 'This is a test', '<h1>This is a test</h1>');
    echo 'Email sent.';
  }
}