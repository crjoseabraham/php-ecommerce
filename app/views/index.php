<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<h1> Home Page </h1>
	<hr>
	<div class="products-container">
	<?php foreach ($data as $item) : ?>
	<div class="product-card">
		<img src="<?= $item['picture']; ?>" alt="<?= $item['description']; ?>" class="product-card__img">
		<hr>
		<div class="product-card__product-details">
			<p class="product-card__product-name"> <?= $item['description']; ?> </p>
			<span class="product-card__product-price"> $<?= $item['price']; ?> </span>
		</div>
		<form action="" class="product-card__form">
			<input type="number" class="product-card__quantity" name="quantity">
			<button type="submit"> Add </button>
		</form>
		<p class="product-card__rating"> Rating: <?= $item['rating']; ?> </p>
	</div>
	<?php endforeach; ?>
	</div>
</body>
</html>
