<?php

// Get URI
function getURI() : string
{
  $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
  $uri = explode('/', $uri);
  array_shift($uri);
  $uri = implode('/', $uri);

  return $uri;
}

// Get METHOD
function getMethod() : string
{
  return $_SERVER['REQUEST_METHOD'];
}

// Function to load a template
function renderView($file, $data = []) : void
{
  // Specify our Twig templates location
  $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/src/views');
  // Instantiate Twig
  $twig = new Twig_Environment($loader);

  echo $twig->render($file, ['data' => $data]);
}