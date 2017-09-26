<?php
$conn = new mysqli("localhost", "root", "", "bramcastillo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>