<?php

session_start();

if(!isset($_SESSION['language'])) {
	$_SESSION['language'] = "English";
}


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
		<?php 
		
			if($_SESSION['language'] == "English") {
				echo "<title>Login</title>";
			} else {
				echo "<title>ログイン</title>";
			}
			
		?>
	</head>
	<body class="fade-in">
<header>
	<?php 
		
		if($_SESSION['language'] == "English") {
			echo "<h3>Login</h3>";
		} else {
			echo "<h3>ログイン</h3>";
		}
		
	?>
</header>
<div class="card medium center">
	<form class="form" method="post" action="login.php">
		<div class="input-field">
			<?php 
		
				if($_SESSION['language'] == "English") {
					echo "<label>Username</label>";
					echo '<input class="text-black-light" pattern=".{4,}" title="Minimum 4 characters" type="text" name="username" required>';
				} else {
					echo "<label>ユーザー名</label>";
					echo '<input class="text-black-light" pattern=".{4,}" title="キャラクターを4個以上入力して下さい" type="text" name="username" required>';
				}
				
			?>
			
		</div>
		
		<div class="input-field">
			<?php 
		
				if($_SESSION['language'] == "English") {
					echo "<label>Password</label>";
					echo '<input class="text-black-light" minlength="6" pattern=".{6,}" title="Minimum 6 characters" type="password" name="password" required>';
				} else {
					echo "<label>パスワード</label>";
					echo '<input class="text-black-light" minlength="6" pattern=".{6,}" title="キャラクターを6個以上入力して下さい" type="password" name="password" required>';
				}
				
			?>
		</div>
		<?php 
	
			if($_SESSION['language'] == "English") {
				echo '<input type="submit" class="btn brd-green" value="Login">';
			} else {
				echo '<input type="submit" class="btn brd-green" value="ログインする">';
			}
			
		?>
		
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