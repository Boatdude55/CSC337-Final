<?php 
	include dirname(__FILE__) . "/controllers/controller.php";
	
	$easyScores = $controller->getScores( "EasyDifficulty" );
	$medScores = $controller->getScores( "MediumDifficulty" );
	$hardScores = $controller->getScores( "HardDifficulty" );
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./styles.global.css"></link>
    </head>
    <body>
    <h1>Boards</h1>
    <div class="scoreDiv">
    	<h3>Easy</h3>
    	<table>
    	<?php 
    	
    	for($i = 0;$i < count($easyScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $easyScores[$i]['highscore'] . "</td>";
    			echo "<td>" . $easyScores[$i]['date_achieved'] . "</td>";
    			echo "<td>" . $easyScores[$i]['time_taken'] . "</td>";
    		echo "</tr>";
    	}
    	
    	?>
    	</table>
    </div>
    <div class="scoreDiv">
   		<h3>Medium</h3>
   		<table>
    	<?php 
    	
    	for($i = 0;$i < count($medScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $medScores[$i]['highscore'] . "</td>";
    			echo "<td>" . $medScores[$i]['date_achieved'] . "</td>";
    			echo "<td>" . $medScores[$i]['time_taken'] . "</td>";
    		echo "</tr>";
    	}
    	
    	?>
    	</table>
    </div>
    <div class="scoreDiv">
    	<h3>Hard</h3>
    	<table>
    	<?php 
    	
    	for($i = 0;$i < count($hardScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $hardScores[$i]['highscore'] . "</td>";
    			echo "<td>" . $hardScores[$i]['date_achieved'] . "</td>";
    			echo "<td>" . $hardScores[$i]['time_taken'] . "</td>";
    		echo "</tr>";
    	}
    	
    	?>
    	</table>
    </div>
    </body>
</html>