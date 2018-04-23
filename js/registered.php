<script type="text/javascript">
'use strict';

var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");
var saveScore = document.getElementById("save-game");

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

saveScore.addEventListener("click", function (e) {
    
    //console.info("saving score");
    game.clear();
    game.setDifficulty(e.target.dataset.value);
    game.fillMap();
    game.drawMap();
    game.on = true;
    var score = scoreBoard.innerHTML;
    score.innerHTML = "0";
    var difficulty = game.difficulty;
    console.log(score);
    console.log(difficulty);
    
}, false);
</script>