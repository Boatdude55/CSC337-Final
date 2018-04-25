<?php

	/*
    if ( isset($_POST["rank"]) ) {
        
        /* Values */
        /*
        echo json_encode($_POST["score"]) .
        json_encode($_POST["time"]) .
        json_encode($_POST["rank"]);
        *
        
        if ( isset($_SESSION["registered-user"]) ) {
            
            //Put Save service here
            
            echo "saved";
            exit();//So the rest of the page is served as part of ajax response
            
        }else{
            
            echo "Login to Save Scores";
            exit();//So the rest of the page is served as part of ajax response
        }
        
         $_POST = array();//To avoid wierdness while I was testing, might be permanent
         
    }
    */
?>

<!-- Functions Only for registered and logged in users-->
<script type="text/javascript">

'use strict';
function dynamicList ( elems, activeCSS, defaultCSS, func,cb ) {
    
    var list = elems;
    var destClass = activeCSS;
    var srcClass = defaultCSS;
    var targetMethod = func;
    var callback = cb;
    
    function deActivate () {
        
        var regex = new RegExp(destClass,"gi");
        
        for ( var i = 0; i < list.length; i++ ) {
                
            if ( regex.test(list[i].className) ) {
                
                var temp = list[i].className.replace( regex, srcClass );
                list[i].className = temp;
                temp = '';
            }
            
        }
    }
    
    this.change = function ( event ) {
        
        deActivate();
        
        var regex = new RegExp(srcClass, "gi");
        var temp = event.target.className;
        var data = event.target.dataset.value;
        
        event.target.className = temp.replace(regex, destClass);
        
        temp = '';
        
        targetMethod( data );
        callback();
        
    };
    
}

var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");
var saveScore = document.getElementById("save-game");

var styleSiblings = styler.children;
var styleHandler = new dynamicList(styleSiblings, "active", "hover",
function ( style ) {
    
    if ( style !== undefined ) {
        game.setStyle(style);
    }
    
    return;
}
, NewGame );
styler.addEventListener("click",styleHandler.change);

var diffSiblings = difficulty.children;
var difficultyHandler = new dynamicList(diffSiblings, "active", "hover",
function ( difficulty ) {
    game.setDifficulty(difficulty);
    return;
}
, NewGame );
difficulty.addEventListener("click",difficultyHandler.change);

//Save score handler
saveScore.addEventListener("click", function (e) {
    
    game.clear();
    game.fillMap();
    game.drawMap();
    game.on = true;
    
    var difficulty = game.getDifficulty();
    //4 or 3 = Intermediate, 7 = Easy, 2 = Hard
    var score = scoreBoard.value;
    var time = clock.value;

    var ajax = new XMLHttpRequest();
	ajax.open("GET", "test.php?difficulty=" + difficulty + "&score=" + score + "&time=" + time, true); //Cannot be done with POST
	ajax.send();

	/*
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			console.log(ajax.responseText);
		}
	}

	
    console.log("Score: " + scoreBoard.value);
    console.log("Time: " + clock.value);
    console.log("Difficulty: " + difficulty);
    */
    
    scoreBoard.value = "0";
    clock.value = "000";

}, false);

</script>