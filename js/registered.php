<script type="text/javascript">
'use strict';

var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");

styler.addEventListener("click", function (e) {
        
    //console.info("styling");
    game.clear();
    game.setStyle(e.target.value);
    game.fillMap();
    game.drawMap();
    game.on = true;
    
}, false);

difficulty.addEventListener("click", function (e) {
        
    //console.info("changing difficulty");
    game.clear();
    game.setDifficulty(e.target.dataset.value);
    game.fillMap();
    game.drawMap();
    game.on = true;
    
}, false);
</script>