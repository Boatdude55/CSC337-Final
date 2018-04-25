<!-- Functions Only for registered and logged in users-->
<script type="text/javascript">

'use strict';

var styler = document.getElementById("styles");
var difficulty = document.getElementById("difficulty");
var saveScore = document.getElementById("save-game");

styler.addEventListener("click", function (e) {
    
    var style = e.target.dataset.value;
    
    if ( style !== undefined ) {
        game.setStyle(style);
    }
    
    NewGame();
});

difficulty.addEventListener("click", function (e) {
    
    var diff = e.target.dataset.value;
    
    if ( diff !== undefined ) {
        game.setDifficulty(diff);
    }
    NewGame();
});

//Save score handler
saveScore.addEventListener("click", function (e) {
    
    var difficulty = game.getDifficulty();
    
    var score = scoreBoard.value;
    var time = clock.value;
    NewGame();
    
    var ajax = new XMLHttpRequest();
	ajax.open("GET", "score_saver.php?difficulty=" + difficulty + "&score=" + score + "&time=" + time, true); //Cannot be done with POST
	ajax.send();

	
	ajax.onreadystatechange = function() {
	    
		if (ajax.readyState == 4 && ajax.status == 200) {
		    
			modalContent.innerHTML = this.responseText;
			modalContent.style.color = "rgb(100,255,100)";
			modal.style.display = "block";
			
		}else {
		    
		    modalContent.innerHTML = "Error saving file";
			modalContent.style.color = "rgb(255,0,0)";
			modal.style.display = "block";
			
		}
		
	};
	
}, false);

//Language features
var langButton = document.getElementById("lang-toggle");
langButton.addEventListener("click", function (e) {

	var ajax = new XMLHttpRequest();
	ajax.open("GET", "score_saver.php?language=changeme");
	ajax.send();

	location.reload();
	
}, false);

</script>