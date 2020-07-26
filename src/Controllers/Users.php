<?php
namespace App\Controller;

class Users {

    public function register() {
        echo "true";
    }

    public function userExists() {
        var_dump($_POST);
    }
}