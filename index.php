<?php

session_start();

if(!isset($_SESSION['language'])) {
	$_SESSION['language'] = "English";
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="./js/main.js"></script>
		<link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
		<?php 
		
		if($_SESSION['language'] == "English") {
			echo "<title>Minesweeper</title>";
		} else {
			echo "<title>マインスイーパー</title>";
		}
		
		?>
	</head>
	<body class="container fade-in">
		<div class="hidden">
			<img id="tileset" src="./assets/minesweeper-tileset.png"></img>
		</div>
		<div id="ui-modal" class="modal">
			<div class="modal-container zoom-in">
				<span id="close" class="close">&times;</span>
				<section id="ui-modal-content" class="fade-in">GAME OVER</section>
			</div>
		</div>
		<header class="grey-light">
			<?php 
			
			if($_SESSION['language'] == "English") {
				echo '<span class="logo right">MineSweeper</span>';
			} else {
				echo '<span class="logo right">マインスイーパー</span>';
			}
			
			?>
			
			<nav class="nav-bar">
				<?php 
				
				if($_SESSION['language'] == "English") {
					echo '<a class="nav-item text-green" name="mode" href="./register.php">Register</a>';
					echo '<a class="nav-item text-green" name="mode" href="./login.php">Login</a>';
					echo '<a class="nav-item text-green" name="mode" href="./boards.php">Leader Boards</a>';
				} else {
					echo '<a class="nav-item text-green" name="mode" href="./register.php">アカウントを作成</a>';
					echo '<a class="nav-item text-green" name="mode" href="./login.php">ログイン</a>';
					echo '<a class="nav-item text-green" name="mode" href="./boards.php">リーダーボード</a>';
				}
				
					if ( isset($_SESSION['registered-user']) ) {
						
						if($_SESSION['language'] == "English") {
							echo '
							<form method="get" action="index.php">
								<button class="btn text-gold" type="submit" name="logout" value="logout">Logout</button>
							</form>
							';
						} else {
							echo '
							<form method="get" action="index.php">
								<button class="btn text-gold" type="submit" name="logout" value="logout">ログアウト</button>
							</form>
							';
						}
						
						
						if($_SESSION['language'] == "English") {
							echo '<h4>Welcome, ' . $_SESSION['user-name'] . "</h4>";
						} else {
							echo '<h4>ようこそ, ' . $_SESSION['user-name'] . "</h4>";
						}
 
						if($_SESSION['language'] == "English") {
							echo '<img id="lang-toggle" class="lang-button" src="assets/japanese.png" alt="日本語" height="32" width="32">';
						} else {
							echo '<img id="lang-toggle" class="lang-button" src="assets/english.png" alt="English" height="32" width="32">';
						}
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
				    <canvas class="card" id="game" width="800" height="600" style="width: 800px; height: 600px;">
                        Canvas not supported upgrade to evergreen browser
                    </canvas>
				</div>
				<div class="col">
					<div id="user-panel" class="card green-light">
						<span id="info" data-target="instructions">?</span>
						<hr class="divider">
						<div class="card-content">
							<div class="row">
								<?php 
								
								if($_SESSION['language'] == "English") {
									echo '<div class="col no-cursor">SCORE:&nbsp;<input class=" no-cursor" type="text" form="save" id="score-board" name="pts" value="0" readonly> PTS</div>';
								} else {
									echo '<div class="col no-cursor">スコア:&nbsp;<input class=" no-cursor" type="text" form="save" id="score-board" name="pts" value="0" readonly> ポイント</div>';
								}
								
								?>
								
								<div class="col no-cursor"><input class=" no-cursor" type="text" form="save" id="clock" name="time" value="000" readonly></div>
							</div>
							<hr class="divider">
							<?php
								if ( isset($_SESSION["registered-user"]) ) {
									if($_SESSION['language'] == "English") {
										echo '
										<div>
						    				<div class="row">
						    					<div class="col">
						    					    <div id="styles" class="vertical-menu">
						    					    	<h5 class="header">Styles</h5>
						    					    	<button type="button" data-value="green"  class="green hover">green</button>
						                				<button type="button" data-value="orange"  class="orange hover">orange</button>
						                				<button type="button" data-value="red"  class="red hover">red</button>
						                				<button type="button" data-value="black"  class="black hover">black</button>
						                				<button type="button" data-value="blue"  class="blue hover">blue</button>
						                				<button type="button" data-value="purple"  class="purple hover">purple</button>
						                				<button type="button" data-value="grey"  class="grey hover">grey</button>
						                				<button type="button" data-value="light-blue"  class="light-blue hover">light-blue</button>
						            				</div>
						    					</div>
						    					<div class="col">
						    					    <div id="difficulty" class="vertical-menu">
						    					    	<h5 class="header">Level</h5>
						    					    	<button type="button" data-value="7" class="green-light">Easy</button>
						                				<button type="button" data-value="4" class="green-light">Intermediate</button>
						                				<button type="button" data-value="2" class="green-light">Hard</button>
						            				</div>
						    					</div>
						    				</div>
						    			</div>
									';
									} else {
										echo '
										<div>
						    				<div class="row">
						    					<div class="col">
						    					    <div id="styles" class="vertical-menu">
						    					    	<h5 class="header">スタイル</h5>
						    					    	<button type="button" data-value="green"  class="green hover">緑</button>
						                				<button type="button" data-value="orange"  class="orange hover">オレンジ</button>
						                				<button type="button" data-value="red"  class="red hover">赤</button>
						                				<button type="button" data-value="black"  class="black hover">黒</button>
						                				<button type="button" data-value="blue"  class="blue hover">青</button>
						                				<button type="button" data-value="purple"  class="purple hover">紫</button>
						                				<button type="button" data-value="grey"  class="grey hover">グレー</button>
						                				<button type="button" data-value="light-blue"  class="light-blue hover">水色</button>
						            				</div>
						    					</div>
						    					<div class="col">
						    					    <div id="difficulty" class="vertical-menu">
						    					    	<h5 class="header">レベル</h5>
						    					    	<button type="button" data-value="7" class="hover green-light">下級</button>
						                				<button type="button" data-value="4" class="hover green-light">中級</button>
						                				<button type="button" data-value="2" class="hover green-light">上級</button>
						            				</div>
						    					</div>
						    				</div>
						    			</div>
									';
									}
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
								<?php 
								
								if($_SESSION['language'] == "English") {
									echo '<button class="btn bdr-green text-green" id="new-game" type="button">New Game</button>';
									echo '<button class="btn bdr-green text-green" id="save-game" type="button">Save Score</button>';
								} else {
									echo '<button class="btn bdr-green text-green" id="new-game" type="button">再開する</button>';
									echo '<button class="btn bdr-green text-green" id="save-game" type="button">スコアを保存する</button>';
								}
								
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			
			if($_SESSION['language'] == "English") {
				echo '<div id="instructions" class="row"><h2 class="header">Instructions</h2></div>
					<div class="row">
						<div class="col">
							<div class="instruction-set" id="rules">
								<h2 class="header">Rules</h2>
								<ol>
									<li>Clicking a square which doesn\'t have a mine reveals the number of neighbouring squares containing mines.</li>
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
					</div>';
			} else {
				echo '<div id="instructions" class="row"><h2 class="header">やり方</h2></div>
					<div class="row">
						<div class="col">
							<div class="instruction-set" id="rules">
								<h2 class="header">ルール</h2>
								<ol>
									<li>周りにマインがあるタイルを押したら、いくつあるか、そのタイルが発表します。</li>
									<li>もし、周りにマインがない場合は、そのタイルは周りにマインがないタイルとともに消えます。</li>
								</ol>
							</div>
						</div>
						<div class="col">
							<div class="instruction-set">
								<h2 class="header">プレーやり方</h2>
								<ol>
									<li>タイルを消す為に、マウスでクリックします。</li>
									<li>マインだと思うタイルの上に旗を張る為に、SHIFTを押しながらマウスでクリックします。</li>
								</ol>
							</div>
						</div>
					</div>';
			}
			?>
			
		</div> 
		<footer id="credits" class="footer gold hidden">
			<div class="row">
				<?php 
				
				if($_SESSION['language'] == "English") {
					echo '<span>Made by Ivan Mucyo Ngabo and Danny Chalfoun</span>';
				} else {
					echo '<span>Ivan Mucyo Ngabo　と　Danny Chalfoun　が作ったサイトです</span>';
				}
				
				?>
			</div>
		</footer>
		<script type="text/javascript">
			
			/* Game UI */
				var clock = document.getElementById("clock");
				var timer = new timeController(clock);
				var scoreBoard = document.getElementById("score-board");
				var newGameBtn = document.getElementById("new-game");
				
			/* Modals */
				var modal = document.getElementById("ui-modal");
				var modalBtn = document.getElementById("close");
				var modalContent = document.getElementById("ui-modal-content");
				
				modalBtn.addEventListener("click", function ( event ) {
					
					modal.style.display = "none";
				});
				
				window.addEventListener("click", function ( event ) {
					if ( event.target == modal ) {
						modal.style.display = "none";
					}
				});
            
            /* Footer and Instructions */
				var help = document.getElementById("info");
				var footer = document.getElementById("credits");
				
				/* Footer Events */
				help.addEventListener("click", function ( event ) {
					
					var content = document.getElementById(event.target.dataset.target);
					
					window.scrollTo(0,content.offsetTop);
					
				}, false);
				
				window.addEventListener("scroll", function ( event ) {
					
					if ( (event.target.scrollingElement.scrollHeight - event.target.scrollingElement.scrollTop) === event.target.scrollingElement.clientHeight ) {
						
						footer.className = "footer gold fade-in";
						
					}else {
						
						footer.className = "footer gold hidden";
						
					}
					
				}, false);
				
			/* Game Events*/
			
				/* Function for rendering new game*/
				function NewGame () {
					
                    scoreBoard.value = "0";
                    timer.stop();
                    clock.value = "000";
                    game.clear();
                    game.fillMap();
                    game.drawMap();
                    game.on = true;
				}
				
	            var game = new MineSweeper();
	            var gameCanvas = undefined;
	            var tileSet = document.getElementById("tileset");
	            
	            if ( tileSet.complete ) {

		            try{
		            	
		                gameCanvas = document.getElementById("game");
		                game.init(tileSet,gameCanvas);
		                NewGame();
		                /* New Game Event */
		                newGameBtn.addEventListener("click", NewGame, true);
		                
		                /* Main Game Event */
		                gameCanvas.addEventListener("click", function clicked ( event ) {
		
		                    if ( game.on ) {
		                    	
		                    	if ( !timer.isOn ) {
						            
						            timer.start();
						
						        }
						        
		                        var result = game.onClick(event);
		                        
		                        if ( result === true ) {
		                            
		                            game.on = false;
		                            timer.stop();
		                            modalContent.innerHTML = "GAME OVER";
									modalContent.style.color = "rgb(255,0,0)";
		                            modal.style.display = "block";
		                            
		                        }else{
		                        	
		                            scoreBoard.value = parseInt(scoreBoard.value,10) + result;
		                            
		                        }
		                        
		                    }
		                    
		                }, true);
		                
		            }catch( err ){
		                
		                console.error(err);
		                
		            }
		            
	            };
            
		</script>
		<?php
			if ( isset($_SESSION["registered-user"]) ) {
				
				//Because of this!
				include dirname(__FILE__) . "/js/registered.php";
				
			}
		?>
	</body>
</html>
