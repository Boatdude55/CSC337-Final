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
	<body class="container fade-in">
		<div class="hidden">
			<img id="tileset" src="./assets/minesweeper-tileset.png"></img>
		</div>
		<header class="grey-light">
			<span class="logo right">MineSweeper</span>
			<nav class="nav-bar">
					<a class="nav-item text-green" name="mode" href="./register.php">Register</a>
					<a class="nav-item text-green" name="mode" href="./login.php">Login</a>
					<a class="nav-item text-green" name="mode" href="./boards.php">Leader Boards</a>
					<?php 
						if ( isset($_SESSION['registered-user']) ) {
							
							echo '
							<form method="get" action="index.php">
								<button class="btn text-gold" type="submit" name="logout" value="logout">Logout</button>
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
                        <div id="game-result" class="modal">
                        	<div class="modal-container zoom-in">
                        		<span id="close" class="close">&times;</span>
                        		<header></header>
                        		<section class="fade-in">GAME OVER</section>
                        		<footer></footer>
                        	</div>
                        </div>
					</div>
				</div>
				<div class="col">
					<div id="user-panel" class="card green-light">
						<span id="info" data-target="instructions">?</span>
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
								<div class="col no-cursor">SCORE:&nbsp;<input class=" no-cursor" type="text" form="save" id="score-board" name="pts" value="0" readonly> PTS</div>
								<div class="col no-cursor"><input class=" no-cursor" type="text" form="save" id="clock" name="time" value="000" readonly></div>
							</div>
							<hr class="divider">
							<?php
								if ( isset($_SESSION["registered-user"]) ) {
									echo '
										<div>
						    				<div class="row">
						    					<div class="col">
						    					    <div id="styles" class="vertical-menu">
						    					    	<h5 class="header">Styles</h5>
						        						<input type="button" value="green" class="green hover">
						                				<input type="button" value="orange" class="orange hover">
						                				<input type="button" value="red" class="red hover">
						                				<input type="button" value="black" class="black hover">
						                				<input type="button" value="blue" class="blue hover">
						                				<input type="button" value="purple" class="purple hover">
						                				<input type="button" value="grey" class="grey hover">
						                				<input type="button" value="light-blue" class="light-blue hover">
						            				</div>
						    					</div>
						    					<div class="col">
						    					    <div id="difficulty" class="vertical-menu">
						    					    	<h5 class="header">Level</h5>
						        						<input type="button" data-value="7" value="Easy" class="difficulty hover">
						                				<input type="button" data-value="4" value="Intermediate" class="difficulty hover">
						                				<input type="button" data-value="2" value="Hard" class="difficulty hover">
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
								<button class="btn bdr-green text-green" id="new-game" type="button">New Game</button>
								<form id="save" method="post" action="js/registered.php" onsubmit="saveScore(event)">
									<button class="btn bdr-green text-green" id="save-game" type="submit">Save Score</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="instructions" class="row"><h2 class="header">Instructions</h2></div>
			<div class="row">
				<div class="col">
					<div class="instruction-set" id="rules">
						<h2 class="header">Rules</h2>
						<ol>
							<li>Clicking a square which doesn't have a mine reveals the number of neighbouring squares containing mines.</li>
							<li>If the square has no mines near by it reveals other squares, else the number of mines near by replaces the square.</li>
						</ol>
					</div>
				</div>
				<div class="col">
					<div class="instruction-set">
						<h2 class="header">How to Play</h2>
						<ol>
							<li>To open a square, point at the square and left-click on it.</li>
							<li>To place a flag on a square you think is a bomb, point, hold shift and left-click.</li>
						</ol>
					</div>
				</div>
			</div>
		</div> 
		<footer id="credits" class="footer gold hidden">
			<div class="row">
				<span>Made by Ivan Mucyo Ngabo and Danny Chalfoun</span>
			</div>
		</footer>
		<script type="text/javascript">
			
			/* Global UI */
			var clock = document.getElementById("clock");
			var timer = new timeController(clock);
			var scoreBoard = document.getElementById("score-board");
			var modal = document.getElementById("game-result");
			var modalBtn = document.getElementById("close");
			
				/* Events */
				modalBtn.addEventListener("click", function ( event ) {
					
					modal.style.display = "none";
				});
				
				window.addEventListener("click", function ( event ) {
					if ( event.target == modal ) {
						modal.style.display = "none";
					}
				});
				
            var newGameBtn = document.getElementById("new-game");
            
            /* Footer and Instructions */
			var help = document.getElementById("info");
			var footer = document.getElementById("credits");
				/* Events */
				help.addEventListener("click", function ( event ) {
					
					var content = document.getElementById(event.target.dataset.target);
					
					console.log(content);
					window.scrollTo(0,content.offsetTop);
				}, false);
				
				window.addEventListener("scroll", function ( event ) {
					
					//Firefox implementation doesn't work on Chrome
					//var scrollPos = event.pageY;
					//var max = event.target.scrollingElement.scrollTopMax;
					
					//if ( scrollPos == max ) {
					
					//Chrome implementation
					if ( (event.target.scrollingElement.scrollHeight - event.target.scrollingElement.scrollTop) === event.target.scrollingElement.clientHeight ) {
						
						footer.className = "footer gold fade-in";
						
					}else {
						
						footer.className = "footer gold hidden";
						
					}
					
				}, false);
				
			/* Game */
            var game = new MineSweeper();
            var gameCanvas = undefined;
            var tileSet = document.getElementById("tileset");
            
            try{
            	
                gameCanvas = document.getElementById("game");
                game.init(tileSet,gameCanvas);
                
                newGameBtn.addEventListener("click", function () {
                    
                    //console.info("new game");
                    scoreBoard.value = "0";
                    timer.stop();
                    clock.value = "000";
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
                            modal.style.display = "block";
                            console.log(modal.style.display);
                        }else{
                            
                            scoreBoard.value = parseInt(scoreBoard.value,10) + result;
                            
                        }
                        
                    }
                    
                }, true);
                
            }catch( err ){
                
                console.error(err);
                
            }
            
		</script>
		<?php
			if ( isset($_SESSION["registered-user"]) ) {
				
				include dirname(__FILE__) . "/js/registered.php";
				
			}
		?>
	</body>
</html>