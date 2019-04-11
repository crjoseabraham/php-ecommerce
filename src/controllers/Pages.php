<?php
namespace Controller;

use \App\Config;
use \Model\User;

class Pages
{

  public function index()
  {
    Config::renderView('index.html');
  }

  public function store()
  {
    Config::renderView('store.html');
  }

  public function login()
  {
    Config::renderView('login.html');
  }

  public function register()
  {
    if (Config::getMethod() === 'GET') 
    {
      Config::renderView('register.html');
    } 
    elseif (Config::getMethod() === 'POST') 
    {
      $user = new User($_POST);
      if ($user->registerUser())
      {
        echo "Success";
      }
      else 
      {
        Config::renderView('register.html', $user->errors);
      }
    }
  }
}