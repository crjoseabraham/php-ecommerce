<?php 
echo "<h1> Home page </h1><br><br>";
foreach ($data as $item) {
	echo " <ul>
	<li> ID: {$item['product_id']} </li>
	<li> Description: {$item['description']} </li>
	<li> Price: {$item['price']} </li>
	<li> Picture: {$item['picture']} </li>
	<li> Rating: {$item['rating']} </li>
	</ul>";
}
?>