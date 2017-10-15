<?php
require_once 'operations.php';

$item_id = $_POST['item_id'];
$operation = new Operations();
$delete = $operation->DeleteFromCart($item_id);
if ($delete)
{
  $operation->ShowCart();
}
else
{
  echo "Something went wrong"; 
}
?>
