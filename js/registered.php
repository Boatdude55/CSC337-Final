<?php
    
    if ( isset($_POST) ) {
        /*
        print("<pre>".print_r($_POST,true)."</pre>");
        */
    }
?>
<script type="text/javascript">
'use strict';

var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");

styler.addEventListener("click", function (e) {
        
    //console.info("styling: ", e.target.value);
    var style = e.target.value;
    
    if ( style !== undefined ) {
    
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
        
    //console.info("changing difficulty",e.target.dataset.value);
    
    game.clear();
    game.setDifficulty(e.target.dataset.value);
    game.fillMap();
    game.drawMap();
    game.on = true;
    
}, false);

function saveScore ( event ) {
    
    event.preventDefault();
    
    var form = event.target;
    //Values being sent
    //console.log(form[0], form[1], form[2]);
    
    game.clear();
    game.fillMap();
    game.drawMap();
    game.on = true;
    
    form.submit();
    
    scoreBoard.value = "0";
    clock.value = "000";
    
}
</script>