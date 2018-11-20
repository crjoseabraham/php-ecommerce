<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
</head>
<body>
	<h1> Home Page </h1>
	<hr>
	<div class="products-container">
		
	<?php foreach ($data as $item) : ?>
	<div class="product-card">
		<img src="<?= URLROOT . '/' .$item['picture']; ?>" alt="<?= $item['description']; ?>" class="product-card__img">
		<hr>
		<div class="product-card__product-details">
			<p class="product-card__product-name"> <?= $item['description']; ?> </p>
			<span class="product-card__product-price"> $<?= $item['price']; ?> </span>
		</div>
		<form action="<?= URLROOT; ?>/cart/add" class="product-card__form" method="post">
			<input type="hidden" name="price" value="<?= $item['price']; ?>">
			<input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
			<input type="number" name="quantity">
			<button type="submit"> Add </button>
			<br>
			<span class="product-card__error">
				<?= !empty($item['quantity_err']) ? $item['quantity_err'] : ''; ?>
			</span>
		</form>
		<p class="product-card__rating"> Rating: <?= $item['rating']; ?> </p>
	</div>
	<?php endforeach; ?>

	</div>
</body>
</html>
