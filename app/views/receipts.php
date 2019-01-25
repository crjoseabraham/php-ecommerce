<table>
	<thead>
		<th>ID</th>
		<th>Date</th>
		<th>Total</th>
		<th> &nbsp; </th>
	</thead>
	<tbody>
		<?php foreach ($data["receipt"] as $receipt) : ?>
			<tr>
				<td> <?= $receipt["order_id"]; ?> </td>
				<td> <?= $receipt["created_at"]; ?> </td>
				<td> <?= $receipt["total"]; ?> </td>
				<td> 
					<form action="<?= URLROOT; ?>/PDF/printReceipt" method="post">
						<input type="hidden" name="print_orderId" value="<?= $receipt["order_id"]; ?>">
						<button type="submit">Print</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>