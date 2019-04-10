<?php
namespace Controller;

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
}
