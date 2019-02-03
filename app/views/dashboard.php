<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard &mdash; PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
</head>
<body>
	<section class="sidebar">
		<div class="sidebar__top-bar">
			<p> <?= $_SESSION['cash']; ?> </p>
			<p> <a href="<?= URLROOT; ?>/index/logout"> Logout </a> </p>
		</div>

		<?php include 'cart.php'; ?>

		<div class="sidebar__transport">
			
			<!-- Select transport type:

			<form action="<?= URLROOT; ?>/carts/pay" method="post">
				<select name="transport-type" id="transport-type">
					<option value="0"> Pick up </option>
					<option value="4"> UPS (+4$)</option>
				</select>

				<div class="cart__amount">
				<b> Total: </b> $<span id="cart__total"><?= $total; ?></span>
				</div>

				<button type="submit"> Pay </button>
			</form> -->
		</div>
	</section>
	
	<section class="products">
		<?php include 'products.php' ?>
	</section>

	<!-- 
	<div class="container">
		<div class="cart-container">
			
		</div>

		<div class="receipts-container">
			<?php include 'receipts.php'; ?>
		</div>

		<div class="products-container">
			
		</div>
	</div> -->

<script src="<?= URLROOT; ?>/js/app.js"></script>
</body>
</html>