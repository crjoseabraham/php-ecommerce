<?php
session_start();
require_once 'dbconnection.php';

$total = $_POST['total_amount'];
$_SESSION['cash'] -= $total;

$delete = "DELETE FROM details";
$conn->query($delete);
if ($conn->query($delete) === TRUE) {    
} else {
    echo "Error: " . $delete . "<br>" . $conn->error;
}

$conn->close();
?>