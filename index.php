<?php 
session_start(); 
if(!isset($_SESSION['cash']))
{
    $_SESSION['cash'] = 1000;
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
</head>

<body>
  <nav class="navbar">    
      <h2 id="display-cash" style="float:left;">Current cash: 
        <?php echo number_format($_SESSION['cash'], 2, '.', '')." $"; ?>
        <input type="hidden" name="cash-input" class="cash-input" value="<?php echo $_SESSION['cash']; ?>">
      </h2>
      <div class="copyright" style="float:right;padding: 5px 20px 0px 0px;">
      <span style="font-size:13px; padding:13px;">Created by José A. Castillo |</span> 
      <a href="http://github.com/joseabrahamce"><img src="images/github.png" alt="GitHub"></a>
      <a href="http://instagram.com/joseabrahamce"><img src="images/instagram.png" alt="Instagram"></a>
      <a href="mailto:abrahamcr3@gmail.com"><img src="images/mail.png" alt="Send Email"> </a>
      </div>
      <div style="clear:both;"></div>
  </nav>       
        
  <div class="container">   
   <input id="slide-sidebar" class="toggle" type="checkbox" role="button" />
        <label for="slide-sidebar" class="toggle-label"><i class="fa fa-bars" aria-hidden="true"></i></label>
   <div class="cart-details">
    <br>
    <center>
        <b>— ORDER SUMMARY —</b>
    </center>
    <hr>
    <div class="summary">
      <?php
      require_once 'operations.php';
      $operation = new Operations();
      $operation->ShowCart();
      ?>
    </div>
   </div>
   <div class="products">
      <?php      
      $operation = new Operations();
      $operation->ShowProducts();
      ?>
   </div>    
  </div>

<script src="js/jquery-3.2.1.js"></script>
<script src="js/myjavascript2.js"></script>
</body>
</html>
