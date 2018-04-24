<?php

    if ( isset($_POST["rank"]) ) {
        
        /* Values */
        /*
        echo json_encode($_POST["score"]) .
        json_encode($_POST["time"]) .
        json_encode($_POST["rank"]);
        */
        
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
?>

<!-- Functuons Only for registered and logged in users-->
<script type="text/javascript">
'use strict';
console.log("priveledged");
var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");

styler.addEventListener("click", function (e) {
    
    console.info("changing style");
    var style = e.target.value;
    
    if ( style !== undefined ) {
        
        scoreBoard.value = "0";
        timer.stop();
        clock.value = "000";
        game.clear();
        game.setStyle(style);
        game.fillMap();
        game.drawMap();
        game.on = true;
        
    }else {
        
        var msg = "Undefined color: click directly on button";
        console.info(msg);
    }
    
}, false);

difficulty.addEventListener("click", function (e) {
    console.info("setting difficulty");
    scoreBoard.value = "0";
    timer.stop();
    clock.value = "000";    
    game.clear();
    game.setDifficulty(e.target.dataset.value);
    game.fillMap();
    game.drawMap();
    game.on = true;
    
}, false);

</script>