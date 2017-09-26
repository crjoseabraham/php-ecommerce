<?php
session_start();
require_once 'dbconnection.php';

$sessionid = session_id();
$rate_value = $_POST['rate'];
$itemid = $_POST['item_id'];

$query1 = "SELECT id FROM tbl_rating WHERE sessionid='$sessionid' AND productid='$itemid'";
$result = $conn->query($query1);
$row = $result->fetch_assoc();
if ($result->num_rows > 0) {
    echo "<script> alert('You already rated this item. You can only vote once per session'); </script>";
    $votes = $conn->query("SELECT COUNT(*) as `total` FROM tbl_rating WHERE productid='$itemid'");
    $totalvotes = $votes->fetch_assoc();
    $avg = $conn->query("SELECT AVG(`rate`) as `average` FROM tbl_rating WHERE productid='$itemid'");
    $avg_result = $avg->fetch_assoc();
    echo "Rating: ".number_format((float)$avg_result['average'],1,'.','')."/5 ";
    echo "(of ".$totalvotes['total']." votes)";
} else {
    $sql = "INSERT INTO tbl_rating (productid, rate, sessionid) VALUES ('$itemid','$rate_value','$sessionid')";
    if ($conn->query($sql) === TRUE) {
        $votes = $conn->query("SELECT COUNT(*) as `total` FROM tbl_rating WHERE productid='$itemid'");
        $totalvotes = $votes->fetch_assoc();
        $avg = $conn->query("SELECT AVG(`rate`) as `average` FROM tbl_rating WHERE productid='$itemid'");
        $avg_result = $avg->fetch_assoc();
        echo "Rating: ".number_format((float)$avg_result['average'],1,'.','')."/5 ";
        echo "(of ".$totalvotes['total']." votes)";
    } else { echo mysqli_error($conn); }
}
$conn->close();
?>