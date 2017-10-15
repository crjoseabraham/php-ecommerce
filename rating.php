<?php
require_once 'operations.php';

$sessionid = session_id();
$rate_value = $_POST['rate'];
$item_id = $_POST['item_id'];

$operation = new Operations();
$rate = $operation->Rate($sessionid, $item_id, $rate_value);
?>
