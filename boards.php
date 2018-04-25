<?php 

session_start();

if(!isset($_SESSION['language'])) {
	$_SESSION['language'] = "English";
}

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
        <?php 
		
		if($_SESSION['language'] == "English") {
			echo "<title>Leaderboards</title>";
		} else {
			echo "<title>リーダーボード</title>";
		}
		
		?>
    </head>
    <body>
    <?php 
    
    if($_SESSION['language'] == "English") {
    	echo '<h1>Boards</h1>';
    } else {
    	echo '<h1>ボード</h1>';
    }
    
    ?>
    
    <div class="scoreDiv">
    	<?php 
    
	    if($_SESSION['language'] == "English") {
	    	echo '<h2>Easy</h2>
			    	<table>
				    	<tr>
				    		<th>User</th>
				    		<th>Highscore</th>
				    		<th>Date Achieved</th>
				    		<th>Time Taken</th>
				    	</tr>';
	    } else {
	    	echo '<h2>下級</h2>
			    	<table>
				    	<tr>
				    		<th>ユーザー名</th>
				    		<th>ハイスコア</th>
				    		<th>日付</th>
				    		<th>タイム</th>
				    	</tr>';
	    }
    	for($i = 0;$i < count($easyScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $easyScores[$i]['name'] . "</td>";
    			echo "<td>" . $easyScores[$i]['highscore'] . "</td>";
    			echo "<td>" . $easyScores[$i]['date_achieved'] . "</td>";
    			echo "<td>" . $easyScores[$i]['time_taken'] . "</td>";
    		echo "</tr>";
    	}
    	
    	?>
    	</table>
    </div>
    <div class="scoreDiv">
   		<?php 
    
	    if($_SESSION['language'] == "English") {
	    	echo '<h2>Medium</h2>
			    	<table>
				    	<tr>
				    		<th>User</th>
				    		<th>Highscore</th>
				    		<th>Date Achieved</th>
				    		<th>Time Taken</th>
				    	</tr>';
	    } else {
	    	echo '<h2>中級</h2>
			    	<table>
				    	<tr>
				    		<th>ユーザー名</th>
				    		<th>ハイスコア</th>
				    		<th>日付</th>
				    		<th>タイム</th>
				    	</tr>';
	    }
    	for($i = 0;$i < count($medScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $medScores[$i]['name'] . "</td>";
    			echo "<td>" . $medScores[$i]['highscore'] . "</td>";
    			echo "<td>" . $medScores[$i]['date_achieved'] . "</td>";
    			echo "<td>" . $medScores[$i]['time_taken'] . "</td>";
    		echo "</tr>";
    	}
    	
    	?>
    	</table>
    </div>
    <div class="scoreDiv">
    	<?php 
    
	    if($_SESSION['language'] == "English") {
	    	echo '<h2>Hard</h2>
			    	<table>
				    	<tr>
				    		<th>User</th>
				    		<th>Highscore</th>
				    		<th>Date Achieved</th>
				    		<th>Time Taken</th>
				    	</tr>';
	    } else {
	    	echo '<h2>上級</h2>
			    	<table>
				    	<tr>
				    		<th>ユーザー名</th>
				    		<th>ハイスコア</th>
				    		<th>日付</th>
				    		<th>タイム</th>
				    	</tr>';
	    }
    	for($i = 0;$i < count($hardScores);$i++) {
    		echo "<tr>";
    			echo "<td>" . $hardScores[$i]['name'] . "</td>";
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