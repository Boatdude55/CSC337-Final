<?php
include "db.controller.php";

class Controller {
	
	private $dbController = NULL;
	
	public function __construct( DatabaseController $db) {
		
		$this->dbController = $db;
		
	}
	
	public function getIndex (  $flagged = true, $priveledge = false ) {
		
		$unformatedData = $this->dbController->getAllQuotes( $flagged );
		$formatedData = $this->viewController->formatQuotes( $unformatedData );
		
		$indexContent = $this->viewController->renderIndex( $priveledge, $formatedData );

		return $indexContent;
		
	}
	
	public function registerUser ( $username, $password ) {
		
		$valid = $this->dbController->isValid( $username, $password );

		if ( $valid == 0 ) {
			
			return $this->dbController->insertUser( $username, $password );
			
		}else {
			
			return "Account already exists";
			
		}
	}
	
	public function loginUser ( $username, $password ) {

		$valid = $this->dbController->isValid( $username, $password );
		
		if ( $valid !== 2 ) {
			
			return "Invalid credentials, try again";
			
		}else {
			
			return true;
			
		}
	}
	
	public function toggleFlag ( $id, $value, $all = false ) {
		
		$this->dbController->updateFlag( $id, $value, $all );
	}
	
	public function insertScore ( $user, $difficulty, $score, $time ) {
		
		$this->dbController->insertScore( $user, $difficulty, $score, $time );
		
	}
	
	public function getScores ( $difficulty ) {
		$scoreArray = $this->dbController->getAllScores ( $difficulty );
		return $scoreArray;
	}
}

$controller = new Controller( $dbController );

//Tests
//	$str = $controller->getIndex( true );
//	print("<pre>".print_r($str,true)."</pre>");
//	print("<pre>".htmlspecialchars($str)."</pre>");

//	$str = $controller->registerUser( 'Ivan', 'abc' );
//	print("<pre>".print_r($str,true)."</pre>");
//	print("<pre>".htmlspecialchars($str)."</pre>");
?>