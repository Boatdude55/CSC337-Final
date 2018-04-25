<?php

session_start();

//Will only ever get here if SESSION user is set anyways (See line 345 in index.php)
if (isset($_GET['difficulty']) && isset($_GET['score']) && isset($_GET['time'])) {
	include dirname(__FILE__) . "/controllers/controller.php";
	$response = $controller->insertScore($_SESSION['registered-user'], $_GET['difficulty'], $_GET['score'], $_GET['time']);
	header('Location: index.php');
}

?>