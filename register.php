<?php 

session_start();

if(!isset($_SESSION['language'])) {
	$_SESSION['language'] = "English";
}

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
		<?php 
		
		if($_SESSION['language'] == "English") {
			echo "<title>Register User</title>";
		} else {
			echo "<title>アカウント作成</title>";
		}
		
		?>
		
	</head>
	<body class="fade-in">
<header>
	<?php 
		
		if($_SESSION['language'] == "English") {
			echo "<h3>Register</h3>";
		} else {
			echo "<h3>アカウント作成</h3>";
		}
		
	?>
</header>
<div class="card medium center">
	<form class="form" method="post" action="register.php">
		<div class="input-field">
			<?php 
		
				if($_SESSION['language'] == "English") {
					echo "<label>Username</label>";
					echo '<input class="text-black-light" minlength="4" pattern=".{4,}" title="Minimum 4 characters" type="text" name="username" required>';
				} else {
					echo "<label>ユーザー名</label>";
					echo '<input class="text-black-light" minlength="4" pattern=".{4,}" title="キャラクターを4個以上入力して下さい" type="text" name="username" required>';
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
				echo '<input type="submit" class="btn brd-green" value="Register">';
			} else {
				echo '<input type="submit" class="btn brd-green" value="作成する">';
			}
		
		?>
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