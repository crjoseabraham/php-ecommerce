<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
</head>
<body>
	<h1> Home Page </h1> <br>
	<big>Current Money: <?= $_SESSION['cash']; ?></big>
	<hr>
	<div class="container">
		<div class="cart-container">
			<?php include 'cart.php'; ?>
		</div> <!-- Cart Container -->

		<div class="products-container">
			<?php foreach ($data[0] as $product) : ?>
			<div class="product-card">
				<img src="<?= URLROOT . '/' .$product['picture']; ?>" alt="<?= $product['description']; ?>" class="product-card__img">
				<hr>
				<div class="product-card__product-details">
					<p class="product-card__product-name"> <?= $product['description']; ?> </p>
					<span class="product-card__product-price"> $<?= $product['price']; ?> </span>
				</div>
				
				<form action="<?= URLROOT; ?>/cart/add" class="product-card__form" method="post">
					<input type="hidden" name="price" value="<?= $product['price']; ?>">
					<input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
					<input type="number" name="quantity">
					<button type="submit"> Add </button>
					<br>
					<span class="product-card__error">
						<?= !empty($product['quantity_err']) ? $product['quantity_err'] : ''; ?>
					</span>
				</form>

				<form action="<?= URLROOT; ?>/rate" class="product-card__rating" method="post">
					<input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
					<input type="submit" name="rating_value" value="5" class="product-card__star"/>
					<input type="submit" name="rating_value" value="4" class="product-card__star"/>
					<input type="submit" name="rating_value" value="3" class="product-card__star"/>
					<input type="submit" name="rating_value" value="2" class="product-card__star"/>
					<input type="submit" name="rating_value" value="1" class="product-card__star"/>
				</form>
				<p class="product-card__rating"> Rating: <?= $product['rating']; ?> </p>
			</div>
			<?php endforeach; ?>
		</div> <!-- Products Container -->
	</div> <!-- Container -->

<script src="<?= URLROOT; ?>/js/app.js"></script>
</body>
</html>