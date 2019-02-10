<?php $total = 0; ?>
<div class="sidebar__cart-details">
	<h1> Cart details </h1>
	<table>
		<thead>
			<th>Remove item</th>
			<th>Description</th>
			<th>Subtotal</th>
		</thead>

		<tbody>
		<?php foreach ($data["cart"] as $item) : ?>
			<?php $total += $item['subtotal']; ?>
			<tr>
				<td>
					<form action="<?= URLROOT; ?>/carts/delete" method="post">
						<input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
						<button type="submit" class="cart-details__remove"> Remove </button>
					</form>
				</td>
				<td> <?= $item['quantity']; ?> x   
					<?php	foreach ($data["product"] as $product) : ?>
						<?php if ($product['product_id'] == $item['product_id']) : ?>
							<?= $product['description']; ?>
						<?php endif; ?>
					<?php endforeach;	?>
				</td>
				<td>$<?= $item['subtotal']; ?> </td>				
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<div class="sidebar__transport">
	<h1>Select transport type:</h1>

	<form action="<?= URLROOT; ?>/carts/pay" method="post">
		<input type="radio" name="transport-type" id="pickup" value="0" checked>
		<label for="pickup" class="pickup"> Pick Up <br> (No additional costs) </label>

		<input type="radio" name="transport-type" id="ups" value="4">
		<label for="ups" class="ups"> Delivery <br> (Adds $4) </label>

		<div class="cart__amount">
			Total: $<span id="cart__total"><?= $total; ?></span>
		</div>

		<button type="submit"> Pay </button>
	</form>
</div>