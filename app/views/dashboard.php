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
			<input type="checkbox" name="responsive" id="responsive" class="responsive-button">
			<label for="responsive" class="responsive-label"> Show cart ▼ </label>
			<a class="logout-link" href="<?= URLROOT; ?>/index/logout"> Log Out </a>
		</div>

		<div class="sidebar__content">
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
		</div>

	</section>
	
	<section class="products">
		<?php include 'products.php' ?>
	</section>

<script src="<?= URLROOT; ?>/js/app.js"></script>
</body>
</html>