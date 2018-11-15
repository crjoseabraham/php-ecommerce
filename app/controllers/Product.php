<?php 
/**
 * 
 */
class Product
{
	
	public function __construct()
	{
	}

	public function add(array $params)
	{
		echo "
		Params: <br>
		<pre>";
		var_dump($params);
		echo "</pre>";
	}

	public function delete(array $params)
	{
		echo "Delete";
	}
}