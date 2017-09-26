<?php
require_once 'dbconnection.php';
$id=$_POST['item_id'];
$query = "DELETE FROM details WHERE productid='$id'";
$conn->query($query);
if ($conn->query($query) === TRUE) {
	$get_cart_details = "SELECT * FROM details";
  $results = $conn->query($get_cart_details);
  if ($results->num_rows > 0) {
    echo "<table>
          <thead>
          <th>ID</th>
          <th>Name</th>
          <th>Quantity</th>
          <th>Total</th>
          </thead>
          <tbody>";
    // output data of each row
    while($article = $results->fetch_assoc()) {
      echo "<tr>
            <td>".$article['productid']."</td>
            <td>".$article['description']."</td>
            <td>".$article['quantity']."</td>
            <td>".$article['total']."$</td>
            <td>  <button id='remove_button' data-id='".$article['productid']."' type='submit' class='remove-btn'> <i class='fa fa-times' aria-hidden='true'></i> 
            </button>
            </td>
            </tr>";
    }
    echo "</tbody></table>";
    echo "<br><br>";

    $get_total_amount = mysqli_query($conn,'SELECT sum(total) FROM details');
    if (FALSE === $get_total_amount) die("Select sum failed: ".mysqli_error);
    $row = mysqli_fetch_row($get_total_amount);
    $sum = $row[0];
    echo "<center>";
    echo "<button id='pay_button' type='submit' class='pay-btn' data-id='".$sum."'> 
    click here to pay <br>
    <span style='font-size:18px;font-weight:600;'>total amount: ".number_format($sum, 2, '.', '')." $</span>
    </button> </center>";
  }
}
$conn->close();
?>