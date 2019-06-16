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

  // Show menu in the left sidebar
  public function menu() : void
  {
    renderView('templates/menu.html');
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
   * Displays form for recovering user's password
   */
  public function recoverPasswordForm() : void
  {
    renderView('templates/recover_password_form.html');
  }

  // Load cart template in the right sidebar container
  public function loadCart() : void
  {
    renderView('templates/cart.html'); 
  }
}