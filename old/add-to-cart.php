<?php 
require_once 'operations.php';

$item_id = $_POST['item_id'];
$quantity = $_POST['qty'];

$operation = new Operations();
$add = $operation->AddToCart($item_id,$quantity);
if ($add)
{
  $operation->ShowCart();
}
else
{
  echo "Something went wrong";
}
?>
