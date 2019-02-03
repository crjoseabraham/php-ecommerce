<?php $total = 0; ?>
<div class="sidebar__cart-details">
	<h1> Cart details </h1>
	<table>
		<thead>
			<th>Description</th>
			<th>Subtotal</th>
			<th>&nbsp;</th>
		</thead>

		<tbody>
		<?php foreach ($data["cart"] as $item) : ?>
			<?php $total += $item['subtotal']; ?>
			<tr>
				<td> (<?= $item['quantity']; ?>) x   
					<?php	foreach ($data["product"] as $product) : ?>
						<?php if ($product['product_id'] == $item['product_id']) : ?>
							<?= $product['description']; ?>
						<?php endif; ?>
					<?php endforeach;	?>
				</td>
				<td>$<?= $item['subtotal']; ?> </td>
				<td>
					<form action="<?= URLROOT; ?>/carts/delete" method="post">
						<input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
						<button type="submit" class="cart-details__remove"> X </button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>