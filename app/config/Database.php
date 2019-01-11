<?php 
/**
 *  Database Class
 *  Start connection to the database
 */

class Database
{
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $name = DB_NAME;

	private $handler;
	private $error;
	private $statement;
	
	public function __construct()
	{
		$dsn = "mysql:host={$this->host};dbname={$this->name}";
		$options = [
      PDO::ATTR_PERSISTENT => true,  
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
  	];

  	try {
  		$this->handler = new PDO($dsn, $this->user, $this->pass, $options);
  	} catch (PDOException $e) {
  		$this->error = $e->getMessage();
  	}
	}

	/**
	*	Prepare a statement
	* @param string 	The query
	* @return void
	*/
	public function query (string $query) : void
	{
		$this->statement = $this->handler->prepare($query);
	}

  /**
   * Bind values
   */
  public function bind($param, $value, $type = null) 
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;        
        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->statement->bindValue($param, $value, $type);
  }

  /**
   * Execute a prepared statement.
   */
  public function execute() 
  {  
    try {
      return $this->statement->execute();  
     } catch (PDOException $e) {  
      $this->error = $e->getMessage();  
    } 
  }
  
  /**
   * Fetch a single row as a result of a query.
   */
  public function resultSingle() 
  {  
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_ASSOC);  
  } 

  /**
   * Fetch a set of rows as a result of a query.
   */
  public function resultSet() 
  {  
    $this->execute();  
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);  
  }

  /**
   * Fetch a single value.
   */
  public function resultSingleValue() 
  {  
    $this->execute();  
    return $this->statement->fetchColumn();  
  }
}