<?php


//DO NOT MOVE THIS FILE IT MUST BE HERE FOR THE AJAX CALL TO WORK, AND NO I DO NOT KNOW WHY

session_start();

//Will only ever get here if SESSION user is set anyways (See line 345 in index.php)
if (isset($_GET['difficulty']) && isset($_GET['score']) && isset($_GET['time'])) {
	include dirname(__FILE__) . "/controllers/controller.php";
	$controller->insertScore($_SESSION['user-name'], htmlspecialchars($_GET['difficulty']), htmlspecialchars($_GET['score']), htmlspecialchars($_GET['time']));
	
	if($_SESSION['language'] == "English") {
		echo "Saved";
	} else {
		echo "保存済み";
	}
	
}

if(isset($_GET['language'])) {
	if($_SESSION['language'] == "English") {
		$_SESSION['language'] = "Japanese";
	} else {
		$_SESSION['language'] = "English";
	}
}

?>