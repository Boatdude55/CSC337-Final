<?php

include dirname(__DIR__) . "/models/db.model.php";

class DatabaseController {
	
	private $db = NULL;
	
	public function __construct( DatabaseAdaptor $adaptor ) {
		
		$this->db = $adaptor;
		
	}

	public function getAllScores( $difficulty ) {
		
		$scores = $this->db->selectScoreUserJoin("", $difficulty);
		return $scores;
		
	}
	
	public function isValid ( $user, $psd ) {
		
		return $this->db->validateCredentials( $user,$psd );
	}
	
	public function insertUser ( $user, $psd ) {
		
		$columns = array('name', 'password');
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
	
	public function insertScore ( $user, $difficulty, $score, $time ) {
		$difficultyTable = "";
		if($difficulty == 4) {
			$difficultyTable = "MediumDifficulty";
		} else if ($difficulty == 2) {
			$difficultyTable = "HardDifficulty";
		} else {
			//Implies difficulty is 7
			$difficultyTable = "EasyDifficulty";
		}
		
		$userID = $this->db->getID($user);
		$date = date("Y-m-d H:i:s");
		
		$alreadyExists = $this->db->checkScore($userID, $difficultyTable);
		if($alreadyExists) {
			$this->db->updateScore($userID, $score, "uID", $difficultyTable, $date, $time);
		} else {
			$columns = array('uID', 'highscore', 'date_achieved', 'time_taken');
			$values = array($userID, $score, $date, $time);
			
			$this->db->insertScoreDB($columns, $values, $difficultyTable);
		}
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