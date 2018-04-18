<?php 
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
		<header>
		</header>
		<div class="main container">
			<div class="row">
			    <div class="col">
					<img id="boom" src="./assets/8-bit/explosion.png" width="0px" height="0px"></img>
				    <img id="tile" src="./assets/tile2.png" width="0px" height="0px"></img>
				    <!-- Tiles
				    <img id="tile" src="./assets/8-bit/tile.png" width="0px" height="0px"></img>
				    <img id="tile" src="./assets/tile2.png" width="0px" height="0px"></img>
				    -->
				    <img id="mine" src="./assets/8-bit/mine.png" width="0px" height="0px"></img>
				    <img id="head" src="./assets/head.png" width="0px" height="0px"></img>
				    <img id="hair" src="./assets/hair.png" width="0px" height="0px"></img>
				    <!--<canvas id="canvas" width="800px" height="600px"></canvas>-->
				    <canvas id="canvas" width="800" height="600" style="width: 800px; height: 600px;">
				    	Canvas not supported upgrade to evergreen browser
				    </canvas>
					
				</div>
				<div class="col card">
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
												<label>tile1</label>
												<label>tile2</label>
												<label>tile3</label>
												<label>tile4</label>
											</div>
											<div class="col input-field">
												<label>mine1</label>
												<label>mine2</label>
												<label>mine3</label>
												<label>mine4</label>
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
								<button class="btn" onclick="new">New Game</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div> 
	<?php
		if ( isset($_SESSION["registered-user"]) ) {
			echo '<script type="text/javascript">
			var character = document.getElementById("character");
			
			</script>';
		}
	?>
	<script type="text/javascript">
    
	    var count = 0;
	    var clock = document.getElementById("clock")
	    var canvas = document.getElementById("canvas");
	    var ctx = canvas.getContext('2d');
	    var Field = undefined;
	    var seed = undefined;
	    var timer = undefined;
	    var minesweeper = new MineSweeper(ctx);
	
	    if ( minesweeper ) {
	        
	        console.info("MineSweeper object created", minesweeper);
	        
	        try {
	            
	            Field = new minesweeper.Canvas(canvas);
	            console.info("Canvas Object created", Field);
	            
	        }catch ( err ) {
	            
	            console.error("Error with CanvasClass constructor", err);
	            
	        }
	        
	        try{
	            
	            seed = new minesweeper.rules(Field.canvas.width, Field.canvas.height, 30, 20, 1);
	            console.info("Game seed created", seed);
	            
	        }catch ( err ) {
	            
	            console.error("Error with rules constructor", err);
	            
	        }
	        
	        try{
	            
	            minesweeper.setup(Field,seed);
	            minesweeper.init(Field);
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
	</script>
	</body>
</html>