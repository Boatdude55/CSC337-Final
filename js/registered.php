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
    
    var difficulty = game.getDifficulty();
    console.log("Difficulty: " + difficulty);

    return;
    
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