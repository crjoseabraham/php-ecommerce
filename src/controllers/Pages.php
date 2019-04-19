<?php
namespace Controller;

use \Model\Product;
use \Model\Cart;
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
    // If user is logged in, get the associated cart
    renderView('store.html', Product::getAll());
  }

  /**
   * Displays login form
   */
  public function login() : void
  {
    // Hide login page if user is already logged in
    if (\Model\Session::getUser())
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
    if (\Model\Session::getUser())
      redirect('/store');
    else
      renderView('register.html');
  }

  public function test() : void
  {
    $cart = isset($_SESSION['user']) ? Cart::getCartItems() : [];
    renderView('test2.html', $cart);
  }
}