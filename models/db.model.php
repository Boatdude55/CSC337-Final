 <?php
// Author: Rick Mercer 
//
class DatabaseAdaptor {
	  // The instance variable used in every one of the functions in class DatbaseAdaptor
	  private $DB;
	  // Make a connection to the data based named 'imdb_small' (described in project). 
	  public function __construct( $dbname, $host, $name ) {
	    $db = "mysql:dbname=$dbname;host=$host;charset=utf8";
	    $user = $name;//'root';
	    $password = "";
	    
	    try {
	      $this->DB = new PDO ( $db, $user, $password );
	      $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	      
	    } catch ( PDOException $e ) {
	      echo ('Error establishing Connection');
	      exit ();
	    }
	  }
	  
	  /**
	   * 
	   * @param string $table
	   * @param string $arrangers
	   * @param string $order
	   * @throws Error
	   * @return array
	   */
	  public function selectAllOrdered ( $condition = "", $table = "quotations", $arrangers = "rating DESC, added", $order = "DESC" ) {
	  	
	  	try{
	  		//WHERE flagged > 0
		  	$stmt = $this->DB->prepare( "SELECT * FROM $table $condition ORDER BY $arrangers $order" );
		  	$stmt->execute ();
		  	
		  	$rows = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	  	
	  		return $rows;
	  		
	  	}catch ( Error $err ) {
	  		
	  		$msg = "Error fetching Database rows: " . $err->getMessage() . " | Code: " .$err->getCode();
	  		throw new Error($msg);
	  		
	  	}
	  	
	  }
	  
	/**
	 * 
	 * @param unknown $case
	 * @param string $table
	 * @param string $column
	 * @param string $test
	 * @throws Error
	 * @return array
	 */
	  public function selectWhere ( $case, $table = "users", $column = "username", $test = "=" ) {
	  	
	  	try{
	  		
	  		
	  		//$rows = "SELECT $column FROM $table WHERE $column $test '$case'";
	  		$stmt = $this->DB->prepare( "SELECT $column FROM $table where $column $test " . $this->typeValidation($case));
	  		$stmt->execute ();
	  		
	  		$rows = $stmt->fetchAll ( PDO::FETCH_ASSOC);
	  		
	  		return $rows;
	  		
	  	}catch ( Error $err ) {
	  		
	  		$msg = "Error fetching Database rows: " . $err->getMessage() . " | Code: " .$err->getCode();
	  		throw new Error($msg);
	  		
	  	}
	  	
	  }
	  
	  public function update ( $case, $value, $column = "rating", $test = "id", $table = "quotations" ){
		
		try{
			
			$validatedValue = $this->typeValidation($value);
			$stmt = $this->DB->prepare( "UPDATE $table SET $column = $validatedValue  WHERE $test = $case"  );
			$stmt->execute ();
			
			return true;
			
		}catch ( Error $err ) {
			
			$msg = "Error updating table data: " . $err->getMessage() . " | Code: " .$err->getCode();
			throw new Error($msg);
			
		}
	}
	
	public function insertInto ( $cols, $values, $table = 'users') {

		try{
			
			$formatedCols = $this->insertColSyntax($cols);
			$formatedValues = $this->insertValueSyntax($values);
			
			$stmt = $this->DB->prepare( "INSERT INTO $table ($formatedCols) values ($formatedValues)" );
			$stmt->execute ();

			return true;
			
		}catch ( Error $err ) {
			
			$msg = "Error updating table data: " . $err->getMessage() . " | Code: " .$err->getCode();
			throw new Error($msg);
			
		}
	}
	
	/* Helpers */
	
	/**
	 * 
	 * @param array $values
	 * @return string
	 */
	private function insertColSyntax ( array $values ) {
		
			return implode(',',$values);
	}
	
	/**
	 * 
	 * @param array $values
	 * @return string
	 */
	private function insertValueSyntax ( array $values ) {
		
		$validated = array();
		
		foreach ( $values as $key=>$val ) {
			
			$validated[] = $this->typeValidation($val);
			
		}
		
		return implode(',',$validated);
	}
	
	/**
	 * 
	 * @param unknown $type
	 * @return string
	 */
	private function typeValidation ( $type ) {
		
		$SQL_BUILTINS = array(
				'CURRENT_TIMESTAMP' => true
		);
		
		$typedCondition = $type;
		
		if ( gettype( $type ) == "string" && !isset($SQL_BUILTINS[$type]) ) {
			
			$typedCondition = "'$type'";

		}else{
			
			$typedCondition = $type;
		}
		
		return $typedCondition;
	}
	
	/**
	 *
	 * @param string $username
	 * @param string $password
	 * @return number
	 */
	public function validateCredentials ( $username, $password ) {
		
		$success = 0;
		
		$stmt = $this->DB->prepare( "SELECT * FROM users where username = '$username'" );
		$stmt->execute ();
		
		$result = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		if ( isset($result[0]['username']) ) {
			
			$password_test = password_verify( $password , $result[0]['hash']) ? 1 : 0;
			$username_test = $result[0]['username'] == $username ? 1 : 0;
			
			$success = $username_test + $password_test;
			
		}
		
		return $success;
		
	}
} // End class DatabaseAdaptor

// Testing code that should not be run when a part of MVC

$ip = getenv('IP');
$username = getenv('C9_USER');
$theDBA = new DatabaseAdaptor ("final", $ip, $username);

//	SelectAllOrdered Test
//	$arr = $theDBA->selectAllOrdered();
//	print("<pre>".print_r($arr,true)."</pre>");

//	SelectWhere Test
//	$arr = $theDBA->selectWhere("Ivan");
//	print("<pre>".print_r($arr,true)."</pre>");

//	insertInto Test
//	$arr = $theDBA->insertInto("H");
//	print("<pre>".print_r($arr,true)."</pre>");

?>