<?php
namespace App\Controller;

class Users {

    public function register() {
        extract($_POST);
        var_dump($_POST);
    }
}