<?php 
require_once 'dbconnection.php';
$item_id = $_POST['item_id'];
$quantity = $_POST['qty'];

$query1 = "SELECT name, price FROM product WHERE id='$item_id'";
$result = $conn->query($query1);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $description = $row['name'];
    $total = $row['price'] * $quantity;
    $insert_to_cart = "INSERT INTO details VALUES ('$item_id', '$description', '$quantity', '$total') ON DUPLICATE KEY UPDATE quantity='$quantity', total='$total'";

    if ($conn->query($insert_to_cart) === TRUE) {
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
              <span style='font-size:18px;font-weight:600;'>total amount: ".number_format($sum, 2, '.', '')." $ </span>
              </button> </center>";
      }
    } else {
      echo "Error: " . $insert_to_cart . "<br>" . $conn->error;
    }
  }
} else {
  echo "0 results";
}
?>