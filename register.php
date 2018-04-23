<?php 

	if ( isset( $_POST['username']) ) {
		
		include dirname(__FILE__) . "/controllers/controller.php";

		$registrationStatus = $controller->registerUser( $_POST['username'], $_POST['password']);
		
		if ( $registrationStatus !== true ) {
			
			$_SESSION["registrationError"] = $registrationStatus;
			
		}else{
			
			header("Location: index.php");
		}
	}

?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
		<title>Register User</title>
	</head>
	<body class="fade-in">
<header>
	<h3>Register</h3>
</header>
<div class="card medium">
	<form class="form" method="post" action="register.php">
		<div class="input-field">
			<label>Username</label>
			<input minlength="4" pattern=".{6,}" title="Minimum 6 characters" type="text" name="username" required>
		</div>
		<div class="input-field">
			<label>Password</label>
			<input minlength="6" pattern=".{4,}" title="Minimum 4 characters" type="password" name="password" required>
		</div>
		<!--<button type="submit" class="btn">Register</button>--><input type="submit" class="btn" value="Register">
	</form>
	<div class="error">
		<?php 
			
			if ( isset($_SESSION["registrationError"]) ) {
			
				echo $_SESSION["registrationError"];
				
			}
			
		?>
	</div>
</div>
	</body>
</html>