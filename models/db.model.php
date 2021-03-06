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
	  
	  public function selectScoreUserJoin ( $table = "EasyDifficulty" ) {
	  
	  	try{
	  		$stmt = $this->DB->prepare( "SELECT * FROM $table JOIN User ON ($table.uID = User.ID) ORDER BY highscore DESC, time_taken DESC" );
	  		//Not from Rick 4/30/2018: Because this query breaks when attempting to use bindParam, not necessary to use. Don't need to have on all queries
	  		$stmt->execute ();
	  		 
	  		$rows = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	  
	  		return $rows;
	  	  
	  	}catch ( Error $err ) {
	  	  
	  		$msg = "Error fetching Database rows: " . $err->getMessage() . " | Code: " .$err->getCode();
	  		throw new Error($msg);
	  	  
	  	}
	  
	  }
	  
	  public function updateScore ( $case, $value, $test, $table, $date, $time ){
		
		try{
			
			$scoreInsert = (int)($value);
			$stmt = $this->DB->prepare( "UPDATE $table SET highscore = $scoreInsert, date_achieved = '$date', time_taken = $time WHERE $test = $case AND highscore < $scoreInsert"  );
			//The second AND condition takes care of only updating highscores when they're beaten
			$stmt->execute ();
			
		}catch ( Error $err ) {
			
			$msg = "Error updating table data: " . $err->getMessage() . " | Code: " .$err->getCode();
			throw new Error($msg);
			
		}
	}
	
	public function checkScore ( $id, $difficultyTable ) {
		$stmt = $this->DB->prepare( "SELECT * FROM $difficultyTable WHERE uID = $id"  );
		$stmt->execute ();
		
		$result = $stmt->fetchAll ( PDO::FETCH_ASSOC);
		if(count($result) >= 1) { //should never be greater than 1, but just in case
			return true;
		} else {
			return false;
		}
	}
	
	public function insertInto ( $cols, $values, $table = 'User') {

		try{
			
			$formattedCols = $this->insertColSyntax($cols);
			$formattedValues = $this->insertValueSyntax($values);
			
			$stmt = $this->DB->prepare( "INSERT INTO $table ($formattedCols) VALUES ($formattedValues)" );
			$stmt->execute ();

			return true;
			
		}catch ( Error $err ) {
			
			$msg = "Error updating table data: " . $err->getMessage() . " | Code: " .$err->getCode();
			throw new Error($msg);
			
		}
	}
	
	public function insertScoreDB ( $cols, $values, $table ) {
		
		try {
			$formattedCols = $this->insertColSyntax($cols);
			$formattedValues = $values[0] . ", " . $values[1] . ", '" . $values[2] . "', " . $values[3];
			
			$stmt = $this->DB->prepare( "INSERT INTO $table ($formattedCols) VALUES ($formattedValues)" );
			$stmt->execute ();
			
		} catch (Error $err) {
			
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
		
		$stmt = $this->DB->prepare( "SELECT * FROM User where name = :username" );
		$stmt->bindParam(':username', $username);
		$stmt->execute ();
		
		$result = $stmt->fetchAll ( PDO::FETCH_ASSOC );

		if ( isset($result[0]['name']) ) {
			
			$password_test = password_verify( $password , $result[0]['password']) ? 1 : 0;
			$username_test = $result[0]['name'] == $username ? 1 : 0;
			
			$success = $username_test + $password_test;
			
		}
		
		return $success;
		
	}
	
	public function getId($userName) {
		$stmt = $this->DB->prepare( "SELECT * FROM User WHERE name = '$userName'" );
		$stmt->execute ();
	
		$result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		return $result[0]['ID']; //I don't need to do any error checking becaues I know the user I am looking for exists (and only once)
	}
} // End class DatabaseAdaptor

// Testing code that should not be run when a part of MVC
//Use whatever relevant credentials
/*
$db = "final";//test database I made: contains users table
$ip = getenv('IP');
$username = getenv('C9_USER');
*/
$db = "minesweeper_service";
$ip = "127.0.0.1";
$username = "root";

$theDBA = new DatabaseAdaptor ($db, $ip, $username);

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