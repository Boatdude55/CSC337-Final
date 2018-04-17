<?php 

if ( isset($_POST['quote']) ) {
	
	include dirname(__FILE__) . "/controllers/controller.php";
	
	$controller->insertQuote( $_POST['quote'], $_POST['author']);
	
	header("Location: quotes.php");
}

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
			<h3>Let's Play</h3>
		</header>
		<div class="main container">
			<div class="row>
			
				<div class="col">
					<img id="boom" src="./assets/8-bit/explosion.png" width="0px" height="0px"></img>
				    <img id="tile" src="./assets/8-bit/tile.png" width="0px" height="0px"></img>
				    <img id="mine" src="./assets/8-bit/mine.png" width="0px" height="0px"></img>
				    <div>
				        <div id="score-board">Score</div>
				        <div id="clock">000</div>
				    </div>
				    <canvas id="canvas" width="800px" height="600px"></canvas>
				</div>
				
				<?php
					echo '<div class="col">
						<p>Registered  User Side Panel</p>
				<p>Can edit game aesthetics</p>
					</div>';
				?>
			        
			 </div>
		</div>  	
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