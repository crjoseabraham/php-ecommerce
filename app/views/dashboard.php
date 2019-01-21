<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard &mdash; PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
</head>
<body>
	<h1> Dashboard Page </h1> <br>
	<strong>Current Money: <?= $_SESSION['cash']; ?></strong> <br>
	<strong><a href="<?= URLROOT; ?>/index/logout"> Logout </a></strong>
	<hr>
	<div class="container">
		<div class="cart-container">
			<?php include 'cart.php'; ?>
		</div>

		<div class="products-container">
			<?php include 'products.php' ?>
		</div>
	</div>

<script src="<?= URLROOT; ?>/js/app.js"></script>
</body>
</html>