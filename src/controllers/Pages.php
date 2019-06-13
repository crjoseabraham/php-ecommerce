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
    renderView('index.html', Products::getAllProducts());
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
    renderView('templates/login_form.html');
  }

  /**
   * Displays register form
   */
  public function register() : void
  {
    renderView('templates/register_form.html');
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
    if (!Session::getUser())
      renderView('forgot-password.html');
    else
      redirect('/store');
  }

  /**
   * Email sent page
   */
  public function emailSent()
  {
    if (!Session::getUser())
      renderView('email-sent.html');
    else
      die('You have no access to this section');
  }
}