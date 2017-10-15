<?php 
if(!isset($_SESSION))
{
	session_start();
}
require('connection.php');

class Operations extends Connect
{
	function __construct()
	{
		parent::__construct();
	}

	public function ShowProducts()
	{
		$sql = "SELECT * FROM product";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0)
		{
			// output data of each row
          	while($row = $result->fetch_assoc()) 
          	{
            	echo "<article>
                      <div class='product-img'>
                        <img src='".$row['img']."'>
                      </div>

                      <div class='price-tag'>                        
                        <b>".$row['price']."$<b> <br>
                        ".$row['name']."                        
                        <br>
                        <input class='add-to-cart' type='number' placeholder='Quantity...' style='float:left;'>
                        <button id='add_button' data-id='".$row['id']."' type='submit' class='add-btn' style='float:right;'>
                          <i class='fa fa-plus' aria-hidden='true'></i>
                        </button>                        
                        <div style='clear:both;'></div>
                        <br>                        
                        <b style='float:left;'>Rate:</b>                        
                        <div class='stars' data-id='".$row['id']."' style='float:right;'>
                          <label title='5 stars'><input class='star' type='radio' name='star' value='5'/></label>
                          <label title='4 stars'><input class='star' type='radio' name='star' value='4'/></label>
                          <label title='3 stars'><input class='star' type='radio' name='star' value='3'/></label>
                          <label title='2 stars'><input class='star' type='radio' name='star' value='2'/></label>
                          <label title='1 star'><input class='star' type='radio' name='star' value='1'/></label>
                        </div>
                        <div style='clear:both;' id='result'>";
              
              	$this->ShowRating($row['id']);
                echo "</div>
                      </div>
                	  </article>";
          }
		}
		else
		{
			echo "No records found";
		}
	}

	public function ShowCart()
	{   
        $sql = "SELECT * FROM details";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0)
		{ 
			echo "<div class='details-table'>
                  <table>
                  <thead>
                  <th></th>
                  <th>Name</th>
                  <th>Total</th>                  
                  </thead>
                  <tbody>";
              
            // output data of each row
            while($article = $result->fetch_assoc())
            {
                echo "<tr>
                      <td>
                        <button id='remove_button' data-id='".$article['productid']."' type='submit' class='remove-btn'>
                          <i class='fa fa-times' aria-hidden='true'></i>
                        </button>
                      </td>
                      <td>".$article['quantity']." x ".$article['description']."</td>
                      <td>".$article['total']."$</td>                      
                      </tr>";
            }
            echo "</tbody>
                  </table>
                  </div>
                  <br>                      
                  ";
            $this->ShippingAndTotal();
        }        
        else
        {
            echo "<div class='details-table'>
                  <div class='badge'> Add items to your cart. They will appear here ▼ </div>
                  </div>";
        }              
	}

	public function AddToCart($item_id, $quantity)
	{
		$sql = "INSERT INTO details (productid, description, quantity, price, total)
			    select product.id, product.name, $quantity, product.price, '$quantity'*product.price
			    from product product
			    where product.id = $item_id
			    ON DUPLICATE KEY UPDATE quantity='$quantity', total='$quantity'*product.price";
		if ($this->conn->query($sql) === TRUE)
		{
		    return true;
		}
		else
		{
		    echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}

	public function DeleteFromCart($item_id)
	{
		$sql = "DELETE FROM details WHERE productid='$item_id'";
		if ($this->conn->query($sql) === TRUE)
		{
			return true;
		}
		else
		{
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}
    
    public function ShippingAndTotal()
    {
        $get_total_amount = $this->conn->query("SELECT sum(total) FROM details");
        if ($get_total_amount === FALSE)
        {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
        $row = mysqli_fetch_row($get_total_amount);
        $sum = $row[0];
        $rest = $_SESSION['cash'] - $sum;
        echo "<div class='shipping'>
              <select name='method' id='method' class='total-amount'>
                <option selected='true' disabled='disabled'>Select the transport type </option>
                <option value='5'>UPS (+5 $)</option>
                <option value='0'>Pick Up (+0 $)</option>
              </select>
              
              <br><br>";
        if($rest >= 0)
        {			
            echo "<center>            	  
                    <button id='pay_button' type='submit' class='pay-btn' data-id='".$sum."'>  
                        <b>click here to pay: <span class='total-span'>".number_format($sum, 2, '.', '')."</span>$</b>
                        <input type='hidden' class='total-amount' value='".$sum."'>
                    </button>
                  </center>
                  <br>                  
                  </div>";
        }
        else
        {
            echo "<br> <i style='font-size:12px; color:red;'> The total amount exceeds your current cash. Please delete some items from your chart</i>
                  </div>";
        }
    }

	public function ProcessPayment($ship)
	{	
        $get_total_amount = $this->conn->query("SELECT sum(total) FROM details");
        if ($get_total_amount === FALSE)
        {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
        $row = mysqli_fetch_row($get_total_amount);
        $sum = $row[0];
        $sum += $ship;
        $_SESSION['cash'] -= $sum;
		$this->conn->query("DELETE FROM details"); //clean cart after processing purchase
	}

	public function Rate($session_id, $item_id, $rate_value)
	{	
		$sql = "SELECT id FROM tbl_rating WHERE sessionid='$session_id' AND productid='$item_id'";
		$result = $this->conn->query($sql);
		$row = $result->fetch_assoc();
		if ($result->num_rows > 0)
		{
		    echo "<script> alert('You already rated this item. You can only vote once per session'); </script>";
		    $this->ShowRating($item_id);
		}
		else
		{
		    $insert = "INSERT INTO tbl_rating (productid, rate, sessionid) VALUES ('$item_id','$rate_value','$session_id')";
		    if ($this->conn->query($insert) === TRUE)
		    {
		    	$this->ShowRating($item_id);		        
		    } 
		    else
		    {
		        echo "Error: " . $insert . "<br>" . $this->conn->error;
		    }
		}
	}

	public function ShowRating($item_id)
	{
		$votes = $this->conn->query("SELECT COUNT(*) as `total` FROM tbl_rating WHERE productid='$item_id'");
		$totalvotes = $votes->fetch_assoc();

		$avg = $this->conn->query("SELECT AVG(`rate`) as `average` FROM tbl_rating WHERE productid='$item_id'");
		$avg_result = $avg->fetch_assoc();

		echo "Rating: ".number_format((float)$avg_result['average'],1,'.','')."/5 (of ".$totalvotes['total']." votes)";
	}
}
?>