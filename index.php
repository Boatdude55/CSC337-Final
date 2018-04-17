<?php
// File Name: index.php
//URL: http://localhost/quotes/index.php

session_start();

//include dirname(__FILE__) . "/controllers/controller.php";
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
		<title>MineSweeper</title>
	</head>
	<body>
	<header>
		<nav class="nav-bar">
			<form method="get" action="index.php">
				<button class="nav-item" type="submit" name="mode" value="register">Register</button>
				<button class="nav-item" type="submit" name="mode" value="login">Login</button>
				<button class="nav-item" type="submit" name="mode" value="play">Play Now</button>
				<?php 
					if ( isset($_SESSION['registered-user']) ) {
						
						echo '<button class="nav-item" type="submit" name="mode" value="play">Edit Account</button>'.
						'<button class="nav-item" type="submit" name="mode" value="play">Edit Field</button>'.
						'<button class="btn right" type="submit" name="logout" value="logout">Logout</button>';
 
					}
				?>
			</form>
		</nav>
	</header>
<?php

if ( !isset($_SESSION['registered-user']) ) {
	
	if ( isset($_GET['mode']) ) {
		
		$mode = $_GET['mode'];
		
		if ( $mode == 'register') {
			
			//echo 'Register';
			include("register.php");
			//header("Location: register.php");
		}
		
		if ( $mode == 'login' ) {
			
			//echo 'Login';
			include("login.php");
			//header("Location: login.php");
			
		}
		
		if ( $mode == 'play' ) {
			
			//echo '<h1>Play MineSweeper</h1>';
			include("play.php");
			//header("Location: play.php");
			
		}
		
	}

}else {
	
	if ( isset($_GET['mode']) ) {
		
		$mode = $_GET['mode'];
		
		if ( $mode == 'register') {
			
			echo 'Register';
			//include("register.php");
			//header("Location: register.php");
		}
		
		if ( $mode == 'login' ) {
			
			echo 'Login';
			//include("login.php");
			//header("Location: login.php");
			
		}
		
		if ( $mode == 'play' ) {
			
			//echo '<h1>Play MineSweeper</h1>';
			include("play.php");
			//header("Location: play.php");
			
		}
		
	}
	
	
	if ( isset($_GET['logout']) ) {
		
		session_unset();
		session_destroy();
		
		header("Location: index.php");
		
	}
	
}
?>
	<script type="text/javascript">
	</script>
	</body>
</html>