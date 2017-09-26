<?php 
  session_start();
  if( !isset($_SESSION['cash']) ){
    $_SESSION['cash'] = 100;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">    
  <link href="css/styles.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/jquery-ui.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar">
    <div style="display: flex; justify-content: space-between;">
      <h3 id="title" style="font-family: Roboto-Regular;">Shopping cart with rating stars system</h3>
      <h3 id="display-cash">Current cash: 
        <?php echo number_format($_SESSION['cash'], 2, '.', '')." $"; ?>
        <input type="hidden" name="cash-input" value="<?php echo $_SESSION['cash']; ?>">
      </h3>
    </div>
  </nav>       
        
  <div class="container">
    <div class="products">
      <?php
      require_once 'dbconnection.php';
      $sql = "SELECT * FROM product";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
          echo "<article>";
          echo "<div class='product-img'> <img src='".$row['img']."'> </div>";
          echo "<div class='price-tag'>";
          echo "<div style='display: flex; justify-content: space-between;'>";
          echo "<h1>".$row['name']."</h1> <h2>".$row['price']."$</h2>";
          echo "</div>";
          echo "<input class='add-to-cart' type='number' placeholder='Quantity...'>
                <button id='add_button' data-id='".$row['id']."' type='submit' class='add-btn'> 
                <i class='fa fa-cart-plus' aria-hidden='true'></i> <span>Add to cart</span>
                </button>
                <br><br>
                <b>Rate this item:</b>
                ";
          echo  "<div class='stars' data-id='".$row['id']."'>
                  <label title='5 stars'><input class='star' type='radio' name='star' value='5'/></label>
                  <label title='4 stars'><input class='star' type='radio' name='star' value='4'/></label>
                  <label title='3 stars'><input class='star' type='radio' name='star' value='3'/></label>
                  <label title='2 stars'><input class='star' type='radio' name='star' value='2'/></label>
                  <label title='1 star'><input class='star' type='radio' name='star' value='1'/></label>
                </div>
                <div id='result'>";
                $votes = $conn->query("SELECT COUNT(*) as `total` FROM tbl_rating WHERE productid='$row[id]'");
                $totalvotes = $votes->fetch_assoc();
                $avg = $conn->query("SELECT AVG(`rate`) as `average` FROM tbl_rating WHERE productid='$row[id]'");
                $avg_result = $avg->fetch_assoc();
                echo "Rating: ".number_format((float)$avg_result['average'],1,'.','')."/5 ";
                echo "(of ".$totalvotes['total']." votes)";
          echo "</div>";
          echo "</div>";
          echo "</article>";
          }
      } else {
          echo "0 results";
      }
      ?>
    </div>

    <div class="cart-details">
      <article style="width:85%;padding:20px;">
        <center><h1> Shopping cart details </h1></center>
        <hr>
      
        <div class="shipping">
        <select name="method" id="method">
          <option selected="true" disabled="disabled">Select the transport type </option>
          <option value="5">UPS (+5 $)</option>
          <option value="0">Pick Up (+0 $)</option>  
        </select>
        </div>
      
        <div class="details-table">
        <?php 
        require_once 'dbconnection.php';                            
        $query = "SELECT * FROM details";
        $results = $conn->query($query);
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
        <span style='font-size:18px;font-weight:600;'>total amount: ".number_format($sum, 2, '.', '')." $ + transport cost</span>
        </button> </center>";
        }
        ?>
        </div>
      </article>              
    </div>
  </div>
        
  <footer>
    Developed by José A. Castillo - abrahamcr3@gmail.com <br>
    github.com/bramcastillo
  </footer>

  <script src="js/jquery-3.2.1.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/myjavascript2.js"></script>    
  </body>
</html>