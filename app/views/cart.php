<?php $total = 0; ?>
<div class="cart__details">
	<table>
		<thead>
			<th>ID</th>
			<th>Product</th>
			<th>Quantity</th>
			<th>Subtotal</th>
			<th>&nbsp;</th>
		</thead>

		<tbody>
		<?php foreach ($data["cart"] as $item) : ?>
			<?php $total += $item['subtotal']; ?>
			<tr>
				<td> <?= $item['product_id']; ?> </td>
				<td> 
					<?php	foreach ($data["product"] as $product) : ?>
						<?php if ($product['product_id'] == $item['product_id']) : ?>
							<?= $product['description']; ?>
						<?php endif; ?>
					<?php endforeach;	?>
				</td>
				<td> <?= $item['quantity']; ?> </td>
				<td> $<?= $item['subtotal']; ?> </td>
				<td>
					<form action="<?= URLROOT; ?>/carts/delete" method="post">
						<input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
						<button type="submit"> Remove </button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<hr>
	<b>Select transport type:</b>
	<form action="<?= URLROOT; ?>/carts/payment" method="post">
		<select name="transport-type" id="transport-type">
			<option value="0"> Pick up </option>
			<option value="4"> UPS (+4$)</option>
		</select>

		<div class="cart__amount">
		<b> Total: </b> $<span id="cart__total"><?= $total; ?></span>
		</div>

		<button type="submit"> Pay </button>
	</form>
</div>