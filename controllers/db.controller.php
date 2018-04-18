<?php

include dirname(__DIR__) . "/models/db.model.php";

class DatabaseController {
	
	private $db = NULL;
	
	public function __construct( DatabaseAdaptor $adaptor ) {
		
		$this->db = $adaptor;
		
	}

	public function getAllScores( $flagged ) {
		
		if ( !$flagged ) {
			
			$criteria = "WHERE flagged > 0";
			$quotes = $this->db->selectAllOrdered( $criteria );
			
		}else {
			
			$scores = $this->db->selectAllOrdered();
			
		}
		return $scores;
		
	}
	
	public function isValid ( $user, $psd ) {
		
		return $this->db->validateCredentials( $user,$psd );
	}
	
	public function insertUser ( $user, $psd ) {
		
		$columns = array('username', 'hash');
		$hashed_psd = password_hash($psd, PASSWORD_DEFAULT);
		
		$values = array($user, $hashed_psd );
		
		$status = $this->db->insertInto( $columns, $values );
		
		return $status;
		
	}
	
	public function updateRating ( $id, $value ) {
		
		return $this->db->update($id,$value);
	}
	
	public function updateScore ( $id, $value ) {
		//public function update ( $case, $value, string $column = "rating", string $table = "quotations" )

		$subject;
		return $this->db->update($id,$value, $subject);

	}
	
	public function updateUserName ( $id, $value ) {
		//public function update ( $case, $value, string $column = "rating", string $table = "quotations" )
		
		$subject;
		return $this->db->update($id,$value, $subject);
		
	}
	
	public function updateHash ( $id, $value ) {
		//public function update ( $case, $value, string $column = "rating", string $table = "quotations" )
		
		$subject;
		return $this->db->update($id,$value, $subject);
		
	}
	
}
$dbController = new DataBaseController( $theDBA );

//Tests
//	$arr = $dbController->getAllQuotes();
//	print("<pre>".print_r($arr,true)."</pre>");

//	$arr = $dbController->insertValue("Hello World!", "PC" );
//	print("<pre>".print_r($arr,true)."</pre>");

//$arr = $dbController->insertUser("Ivan", "abc" );
//	print("<pre>".print_r($arr,true)."</pre>");
?>