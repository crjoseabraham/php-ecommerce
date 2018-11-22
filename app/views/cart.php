<table>
	<thead>
		<th>ID</th>
		<th>Product</th>
		<th>Quantity</th>
		<th>Subtotal</th>
	</thead>

	<tbody>
	<?php foreach ($cartItems as $item) : ?>
		<tr>
			<td> <?= $item['cart_product_id']; ?> </td>
			<td> 
				<?php	foreach ($products as $product) : ?>
					<?php if ($product['product_id'] == $item['cart_product_id']) : ?>
						<?= $product['description']; ?>
					<?php endif; ?>
				<?php endforeach;	?>
			</td>
			<td> <?= $item['quantity']; ?> </td>
			<td> $<?= $item['subtotal']; ?> </td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>