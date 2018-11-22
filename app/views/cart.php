<?php $total = 0; ?>
<table>
	<thead>
		<th>ID</th>
		<th>Product</th>
		<th>Quantity</th>
		<th>Subtotal</th>
		<th>&nbsp;</th>
	</thead>

	<tbody>
	<?php foreach ($cartItems as $item) : ?>
		<?php $total += $item['subtotal']; ?>
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
			<td>
				<form action="<?= URLROOT; ?>/cart/delete" method="post">
					<input type="hidden" name="product_id" value="<?= $item['cart_product_id']; ?>">
					<button type="submit"> Remove </button>
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<br><br>
<?= $total; ?>