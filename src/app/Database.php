<?php 
namespace App;

use \PDO;

/**
 *  Database Class
 *  Start connection to the database
 */
abstract class Database
{
  protected static function getDB()
  {
    static $db = null;
    if ($db === null) 
    {
      $dsn = 'mysql:host=' . DB_HOST .';dbname=' . DB_NAME .';charset=utf8';
      $db = new PDO($dsn, DB_USER, DB_PASS);
      // Throw an Exception when an error occurs
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $db;
  }
}