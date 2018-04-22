<?php
// File Name: index.php
//URL:  https://project-euler-boatrider.c9users.io/CSC337-Final/index.php

session_start();

?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="./js/main.js"></script>
		<link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
		<title>MineSweeper</title>
	</head>
	<body class="container">
		<div class="hidden">
		<img id="tileset" src="./assets/minesweeper-tileset.png"></img>
	</div>
		<header class="grey-light">
			<nav class="nav-bar">
	
					<a class="nav-item text-green" name="mode" href="./register.php">Register</a>
					<a class="nav-item text-green" name="mode" href="./login.php">Login</a>
					<a class="nav-item text-green" name="mode" href="./boards.php">Leader Boards</a>
					<?php 
						if ( isset($_SESSION['registered-user']) ) {
							
							echo '
							<a class="nav-item text-gold" name="mode" value="play" href="./edit.php">Edit Account</a>
							<form method="get" action="index.php">
								<button class="btn right text-gold" type="submit" name="logout" value="logout">Logout</button>
							</form>
							';
	 
						}
					?>
	
			</nav>
		</header>
			<?php

				if ( isset($_SESSION['registered-user']) ) {
					
					if ( isset($_GET['logout']) ) {

						session_unset();

						header("Location: index.php");

					}
				}

			?>
		<div class="main container">
			<div class="row">
			    <div class="col">
			    	<div>
					    <canvas class="card" id="game" width="800" height="600" style="width: 800px; height: 600px;">
                            Canvas not supported upgrade to evergreen browser
                        </canvas>
					</div>
				</div>
				<div class="col">
					<div id="user-panel" class="card green-light">
						<div class="card-img">
						<?php
							if ( isset($_SESSION["registered-user"]) ) {
							echo '
								<div class="card-title">Rank: Private</div>
								<div> Medal goes here </div>
							';
							}else{
								echo '
								<h3 class="advert">Join to keep track of Rank</h3>
								';
							}
						?>
						</div>
						<hr class="divider">
						<div class="card-content">
							<div class="row">
								<div class="col">SCORE:&nbsp<span id="score-board">0</span> PTS</div>
								<div class="col" id="clock">000</div>
							</div>
							<hr class="divider">
							<?php
								if ( isset($_SESSION["registered-user"]) ) {
									echo '
										<div>
						    				<h5>styles</h5>
						    				<div class="row">
						    					<div class="col input-field">
						    					    <div id="styles" class="vertical-menu">
						        						<input type="button" value="green" class="green stylus">
						                				<input type="button" value="orange" class="orange stylus">
						                				<input type="button" value="red" class="red stylus">
						                				<input type="button" value="black" class="black stylus">
						                				<input type="button" value="blue" class="blue stylus">
						                				<input type="button" value="purple" class="purple stylus">
						                				<input type="button" value="grey" class="grey stylus">
						                				<input type="button" value="light-blue" class="light-blue stylus">
						            				</div>
						    					</div>
						    					<div class="col input-field">
						    					    <div class="vertical-menu">
						        						<input type="button" value="Easy" class="difficulty">
						                				<input type="button" value="Intermediate" class="difficulty">
						                				<input type="button" value="Hard" class="difficulty">
						            				</div>
						    					</div>
						    				</div>
						    			</div>
									';
									
								}else{
									echo '
									<h3 class="advert">Login for extra Features</h3>
									';
								}
							?>
						</div>
						<hr class="divider">
						<div class="card-footer">
							<div class="row">
								<form>
									<button class="btn bdr-green text-green" id="new-game" type="button">New Game</button>
									<button class="btn bdr-green text-green" id="save-game" type="button">Save Score</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> 
		<footer class="footer">
			<div class="row">
				<span>Made by Ivan Mucyo Ngabo and Danny Chalfoun</span>
			</div>
		</footer>
		<script type="text/javascript">
		
			var clock = document.getElementById("clock");
			var scoreBoard = document.getElementById("score-board");
            var game = new MineSweeper();
            var gameCanvas = undefined;
            var newGameBtn = document.getElementById("new-game");
            var tileSet = document.getElementById("tileset");
            var timer = new timeController(clock);
            
            try{
            	
                gameCanvas = document.getElementById("game");
                game.init(tileSet,gameCanvas);
                
                newGameBtn.addEventListener("click", function () {
                    
                    //console.info("new game");
                    scoreBoard.innerHTML = "0";
                    timer.stop();
                    clock.innerHTML = "000";
                    game.clear();
                    game.fillMap();
                    game.drawMap();
                    game.on = true;
                    
                }, false);
                
                gameCanvas.addEventListener("click", function clicked ( event ) {
                    
                    if ( game.on ) {
                    	
                    	if ( !timer.isOn ) {
				            
				            timer.start();
				
				        }
				        
                        var result = game.onClick(event);
                        
                        if ( result === true ) {
                            
                            game.on = false;
                            timer.stop();
                            
                        }else{
                            
                            scoreBoard.innerHTML = parseInt(scoreBoard.innerHTML,10) + result;
                            
                        }
                        
                    }
                    
                }, true);
                
            }catch( err ){
                
                console.error(err);
                
            }
            
		</script>
		<?php
			if ( isset($_SESSION["registered-user"]) ) {
				echo '
				<script type="text/javascript">
				
				    var styler = document.getElementById("styles");
				    
					styler.addEventListener("click", function (e) {
			                
			            //console.info("styling");
			            game.clear();
			            game.setStyle(e.target.value);
			            game.fillMap();
			            game.drawMap();
			            game.on = true;
			            
			        }, false);
			        
				</script>';
			}
		?>
	</body>
</html>