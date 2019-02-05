<?php foreach ($data["product"] as $product) : ?>
	<div class="products__product-card" style="background-image: url('<?= URLROOT . '/' .$product['picture']; ?>');">

		<div class="product-card__details">
			<div class="product-card__info">
				<p class="product-card__name"> <?= $product['description']; ?> </p>
				<p class="product-card__price"> $<?= $product['price']; ?> </p>
			</div>

			<form action="<?= URLROOT; ?>/carts/add" class="product-card__form" method="post">
				<button type="button" class="product-card__arrow-button arrow-button--up"> ▲ </button>
				<button type="button" class="product-card__arrow-button arrow-button--down"> ▼ </button>
				<input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
				<input type="number" name="quantity" value="0">
				<button type="submit"> 🞥 </button>
			</form>
		</div>

		<div class="product-card__rating-container">
			<span class="product-card__rating"> Rating: (<?= $product['rating']; ?>/5) </span>

			<form action="<?= URLROOT; ?>/ratings/vote" class="product-card__rating" method="post">
			<input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

			<label for="product<?= $product['product_id']; ?>-1">★</label>
			<input type="submit" name="rating_value" value="1" class="product-card__star" id="product<?= $product['product_id']; ?>-1"/>

			<label for="product<?= $product['product_id']; ?>-2">★</label>
			<input type="submit" name="rating_value" value="2" class="product-card__star" id="product<?= $product['product_id']; ?>-2"/>

			<label for="product<?= $product['product_id']; ?>-3">★</label>
			<input type="submit" name="rating_value" value="3" class="product-card__star" id="product<?= $product['product_id']; ?>-3"/>

			<label for="product<?= $product['product_id']; ?>-4">★</label>
			<input type="submit" name="rating_value" value="4" class="product-card__star" id="product<?= $product['product_id']; ?>-4"/>

			<label for="product<?= $product['product_id']; ?>-5">★</label>
			<input type="submit" name="rating_value" value="5" class="product-card__star" id="product<?= $product['product_id']; ?>-5"/>
			</form>
		</div>
	</div>
<?php endforeach; ?>