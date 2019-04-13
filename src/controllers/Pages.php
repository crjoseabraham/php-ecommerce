<?php
namespace Controller;

use \Model\User;

class Pages
{

  public function index()
  {
    renderView('index.html');
  }

  public function store()
  {
    renderView('store.html');
  }

  public function login()
  {
    if (getMethod() === 'GET')
      renderView('login.html');
    else
    {
      $userModel = new User($_POST);
      $userData = $userModel->authenticate();

      if (is_array($userData))
      {
        echo "Logged in successfully <br> <pre>";
        var_dump($userData);
      }
      else
        renderView('login.html', $userModel->errors);
    }
  }

  public function register()
  {
    if (getMethod() === 'GET')  
      renderView('register.html');

    else
    {
      $user = new User($_POST);

      if ($user->registerUser())
        // NEW SESSION
        // LOAD STORE.html WITH USER LOGGED IN
        echo "Success";
      else 
        renderView('register.html', $user->errors);
    }
  }
}