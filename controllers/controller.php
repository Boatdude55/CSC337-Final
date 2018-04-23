<?php
include "db.controller.php";
include "view.controller.php";

class Controller {
	
	private $dbController = NULL;
	private  $viewController = NULL;
	
	public function __construct( DatabaseController $db, ViewController $view) {
		
		$this->dbController = $db;
		$this->viewController = $view;
		
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
	
	public function changeRating ( $id, $rating ) {
		
		$this->dbController->updateRating($id, $rating);
		
	}
	
	public function toggleFlag ( $id, $value, $all = false ) {
		
		$this->dbController->updateFlag( $id, $value, $all );
	}
	
	public function insertQuote ( $quote, $author ) {
		
		$this->dbController->insertValue( $quote, $author );
		
	}
	
	public function getScores ( $difficulty ) {
		$scoreArray = $this->dbController->getAllScores ( $difficulty );
		return $scoreArray;
	}
}

$controller = new Controller( $dbController, $viewController );

//Tests
//	$str = $controller->getIndex( true );
//	print("<pre>".print_r($str,true)."</pre>");
//	print("<pre>".htmlspecialchars($str)."</pre>");

//	$str = $controller->registerUser( 'Ivan', 'abc' );
//	print("<pre>".print_r($str,true)."</pre>");
//	print("<pre>".htmlspecialchars($str)."</pre>");
?>