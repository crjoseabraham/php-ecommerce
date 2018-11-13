<?php 
class Connect
{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $name = "bramcastillo";
	protected $conn;

	function __construct()
	{
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

		if ($this->conn->error) {
			die("Error trying to access to database: error($this->conn->errno) $this->conn->error" );
		} 
	}
}
?>
