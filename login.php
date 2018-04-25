<?php

	session_start();


if ( isset( $_POST['username']) ) {
	
	include dirname(__FILE__) . "/controllers/controller.php";
	
	$loginStatus = $controller->loginUser( $_POST['username'], $_POST['password']);
	
	if ( $loginStatus !== true ) {

		$_SESSION["loginError"] = $loginStatus;
		
	}else{

		$_SESSION['registered-user'] = "true";
		$_SESSION['user-name'] = $_POST['username'];
		header("Location: index.php");


	}
}

?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
		<title>MineSweeper</title>
	</head>
	<body class="fade-in">
<header>
	<h3>Login</h3>
</header>
<div class="card medium center">
	<form class="form" method="post" action="login.php">
		<div class="input-field">
			<label>Username</label>
			<input class="text-black-light" pattern=".{4,}" title="Minimum 4 characters" type="text" name="username" required>
		</div>
		
		<div class="input-field">
			<label>Password</label>
			<input class="text-black-light" minlength="6" pattern=".{6,}" title="Minimum 6 characters" type="password" name="password" required>
		</div>
		<input type="submit" class="btn brd-green" value="Login">
	</form>
	<div class="error">
		<?php 
			
			if ( isset($_SESSION["loginError"]) ) {
			
				echo $_SESSION["loginError"];
				
			}
			
		?>
	</div>
</div>
	</body>
</html>