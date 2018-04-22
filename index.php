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
	<body>
		<div class="hidden">
		<img id="tileset" src="./assets/minesweeper-tileset.png"></img>
	</div>
		<header>
			<nav class="nav-bar">
	
					<a class="nav-item" name="mode" href="./register.php">Register</a>
					<a class="nav-item" name="mode" href="./login.php">Login</a>
					<a class="nav-item" name="mode" href="./boards.php">Leader Boards</a>
					<?php 
						if ( isset($_SESSION['registered-user']) ) {
							
							echo '
							<a class="nav-item" name="mode" value="play" href="./edit.php">Edit Account</a>
							<form method="get" action="index.php">
								<button class="btn right" type="submit" name="logout" value="logout">Logout</button>
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
					    <canvas id="game" width="800" height="600" style="width: 800px; height: 600px;">
                            Canvas not supported upgrade to evergreen browser
                        </canvas>
					</div>
				</div>
				<div class="col">
					<div id="user-panel" class="card">
						<div class="card-img">
						<?php
							if ( isset($_SESSION["registered-user"]) ) {
							echo '
								<div class="card-title">Rank: Private</div>
								<canvas id="character">Canvas not supported upgrade to evergreen browser</canvas>
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
								<div class="col" id="score-board">Score</div>
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
									<button class="btn" id="new-game" type="button">New Game</button>
									<button class="btn" id="save-game" type="button">Save Score</button>
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

            var game = new MineSweeper();
            var gameCanvas = undefined;
            var newGameBtn = document.getElementById("new-game");
            //var styler = document.getElementById("styles");
            var tileSet = document.getElementById("tileset");

            try{
            	
                gameCanvas = document.getElementById("game");
                game.init(tileSet,gameCanvas);
                /*
                styler.addEventListener("click", function (e) {
                    
                    //console.info("styling");
                    game.clear();
                    game.setStyle(e.target.value);
                    game.fillMap();
                    game.drawMap();
                    game.on = true;
                    
                }, false);
                */
                
                newGameBtn.addEventListener("click", function () {
                    
                    //console.info("new game");
                    game.clear();
                    game.fillMap();
                    game.drawMap();
                    game.on = true;
                    
                }, false);
                
                gameCanvas.addEventListener("click", function clicked ( event ) {
                    
                    if ( game.on ) {
                        
                        //console.info("clicked");
                        
                        if ( game.onClick(event) ) {
                            
                            game.on = false;
                            //console.info("game over");
                            
                        }else{
                            
                            //console.info("game on");
                            
                        }
                        
                    }
                    
                }, true);
                
            }catch(err){
                
                console.error(err);
                
            }
	    /*
	        
    	var Field = undefined;
	    var seed = undefined;
	    var timer = undefined;
	    var canvas = document.getElementById("game");
	    var clock = undefined;
	    var mine = undefined;
	    var tiles = document.getElementById("tileset");
	    var ctx = undefined;
	    
	    var MineSweeper = new MineSweeper();
	    
	    tiles.onload = function () {
	    	
	    	MineSweeper.init(tiles, canvas.width, canvas.height);
	    	MineSweeper.start();
	    	
	    };
	    
	    canvas.addEventListener("click", MineSweeper.onClick );
	    
    	document.addEventListener("loadend", function () {
	    
		    clock = document.getElementById("clock")
		    canvas = document.getElementById("canvas");
			mine = document.getElementById("mine");
			tile = document.getElementById("tile");
		    ctx = canvas.getContext('2d');
			var count = 0;
			
		    var minesweeper = new MineSweeper( ctx );
		
			    if ( minesweeper ) {
			        
			        console.info("MineSweeper object created", minesweeper);
			        minesweeper.CanvasElem.prototype.mine = mine;
			        
			        try {
			        	
			            Field = new minesweeper.Canvas(canvas);
			            console.info("Canvas Object created", Field);
			            
			        }catch ( err ) {
			            
			            console.error("Error with CanvasClass constructor", err);
			            
			        }
			        
			        try{
			            
			            seed = new minesweeper.rules(Field.canvas.width, Field.canvas.height, 30, 20, 4);
			            console.info("Game seed created", seed);
			            
			        }catch ( err ) {
			            
			            console.error("Error with rules constructor", err);
			            
			        }
			        
			        try{
			            
			            minesweeper.setup(Field,seed);
			            tile.onload = function () {
			            minesweeper.init(Field, tile);
			            };
			            console.info("Game setup and started created");
			            
			        }catch ( err ) {
			            
			            console.error("Error with setting up and starting game", err);
			            
			        }
			        
			        try{
			
			            timer = new timeController(clock);console.log(clock,timer);
			            console.info("Timer created", timer);
			            
			        }catch ( err ) {
			            
			            console.error("Error with timeController constructor", err);
			            
			        }
			        
			    }else {
			        
			        console.error("Error instantiating MineSweeper object", minesweeper);
			    }
			    
			    canvas.addEventListener("click", function onclick(event) {
			        
			        if ( !timer.isOn ) {
			            
			            timer.start();
			
			        }
			            
			        if ( Field.onClick(event) ) {
			            
			            event.target.removeEventListener("click", onclick,true);
			            timer.stop();
			            
			        }
			        
			    }, true);
    	},true);
    	*/
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