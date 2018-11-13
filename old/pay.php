<?php
require_once 'operations.php';

$ship = $_POST['ship'];
$operation = new Operations();
$pay = $operation->ProcessPayment($ship);
?>
