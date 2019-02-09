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
			<div class="balance"> Balance: $<?= $_SESSION['cash']; ?> </div>
			<a class="logout-link" href="<?= URLROOT; ?>/index/logout"> Log Out </a>
		</div>

		<?php if (!empty($data['cart'])) : ?>

			<?php include 'cart.php'; ?>			
			
		<?php else : ?>

			<div class="sidebar__cart-not-found">
				<h1>( ·.·)</h1>
				Your cart is empty <br>
			</div>

		<?php endif; ?>

		<div class="sidebar__receipts">
			<h1>Purchase history</h1>
			<?php include 'receipts.php'; ?>
		</div>

	</section>
	
	<section class="products">
		<?php include 'products.php' ?>
	</section>

	<!-- 
	<div class="container">
		<div class="cart-container">
			
		</div>

		<div class="products-container">
			
		</div>
	</div> -->

<script src="<?= URLROOT; ?>/js/app.js"></script>
</body>
</html>