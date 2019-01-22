<?php foreach ($data["product"] as $product) : ?>
	<div class="product-card">
		<img src="<?= URLROOT . '/' .$product['picture']; ?>" alt="<?= $product['description']; ?>" class="product-card__img">
		<hr>
		<div class="product-card__product-details">
			<p class="product-card__product-name"> <?= $product['description']; ?> </p>
			<span class="product-card__product-price"> $<?= $product['price']; ?> </span>
		</div>
		
		<form action="<?= URLROOT; ?>/carts/add" class="product-card__form" method="post">
			<input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
			<input type="number" name="quantity">
			<button type="submit"> Add </button>
		</form>

		<form action="<?= URLROOT; ?>/ratings/vote" class="product-card__rating" method="post">
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