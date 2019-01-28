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
		sidebar
	</section>
	
	<section class="products">
		<?php include 'products.php' ?>
	</section>

	<!-- <strong>Current Money: <?= $_SESSION['cash']; ?></strong> <br>
	<strong><a href="<?= URLROOT; ?>/index/logout"> Logout </a></strong>
	<hr>
	<div class="container">
		<div class="cart-container">
			<?php include 'cart.php'; ?>
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