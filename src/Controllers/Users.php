<?php
namespace App\Controller;

class Users {

    public function register() {
        extract($_POST);
        echo $name;
    }
}