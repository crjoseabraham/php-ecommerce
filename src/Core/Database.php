<?php
namespace App\Core;

use PDO;

/**
 *  Database Class
 *  Start connection to the database
 */
abstract class Database {

    protected static function getDB() {
        static $db = null;
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $name = $_ENV['DB_NAME'];

        if ($db === null) {
            $dsn = "mysql:host={$host};dbname={$name};charset=utf8";
            $db = new PDO($dsn, $user, $pass);
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}