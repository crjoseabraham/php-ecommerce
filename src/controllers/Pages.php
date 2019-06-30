<?php
namespace Controller;

use \Model\Session;

/**
 * Pages Controller
 * Only displays the views for the GET requests
 */
class Pages
{
  // Displays main page
  public function index() : void
  {
    renderView('index.html', [Products::getAllProducts()]);
  }

  // Show menu in the left sidebar
  public function menu() : void
  {
    renderView('components/menu.html');
  }

  // Displays login form
  public function login() : void
  {
    renderView('components/login_form.html');
  }

  // Displays register form
  public function register() : void
  {
    renderView('components/register_form.html');
  }

  // Displays form for recovering user's password
  public function recoverPasswordForm() : void
  {
    renderView('components/recover_password_form.html');
  }

  // Load cart template in the right sidebar container
  public function loadCart() : void
  {
    renderView('components/cart.html', [Carts::getCartItems(), Products::getAllProducts()]);
  }

  // Load cart template in the right sidebar container
  public function addItemForm(int $item_id) : void
  {
    renderView('components/modal.html', [Products::productExists($item_id)]);
  }

  // Load profile template
  public function profile() : void
  {
    renderView('components/profile_template.html', [Receipts::getUserOrders()]);
  }

  // Load form to update basic information (name and email)
  public function updateBasicInfoForm() : void
  {
    renderView('components/update_basic_form.html');
  }

  // Load form to change password
  public function updatePasswordForm() : void
  {
    renderView('components/update_password_form.html');
  }

  // Load page for "Delete account"
  public function deleteAccount(): void
  {
    renderView('components/deactivate_account.html');
  }
}