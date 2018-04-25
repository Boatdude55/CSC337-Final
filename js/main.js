'use strict';

function CanvasMap ( width, height ) {

    this.tileSize = 20;
    this.cols = width/this.tileSize;
    this.rows = height/this.tileSize;
    this.layers = {
        'base':new Array( (this.cols*this.rows) ),
        'flag': new Array( (this.cols*this.rows) ),
        'heap': new Array( (this.cols*this.rows) ),
        'stack': new Array( (this.cols*this.rows) )
    };
    
}
CanvasMap.prototype = {
    getLayer: function ( layer ) {
        
        return this.layers[layer];
        
    },
    getValueAt: function ( x, y, layer = 'base' ) {
        
        if ( x >= this.cols || x < 0 || y >= this.cols || y < 0 ) {
            
            return undefined;
            
        }else {
            
            return this.layers[layer][x + (this.cols*y)];
            
        }
        
    },
    putValueAt: function ( x, y, value , layer = 'base' ) {
        
        try {
            
            if ( x >= this.cols || x < 0 || y >= this.cols || y < 0 ) {
                
                throw new RangeError("Index is out of range: Equation = x + (this.cols*y)");
                
            }else {
                
                this.layers[layer][x + (this.cols*y)] = value;
                
            }
        }catch (err) {
            
            console.error(err);
            
        }

    },
    clear: function ( layer ) {
        
        this.layers[layer].fill(undefined);
        
        return;
        
    }
};

function CanvasEventGrid () {
    
    this.leftClick = false;
    this.shift = false;
    this.coords = undefined;
    
}
CanvasEventGrid.prototype = {
    mapWindowToCanvas: function ( bbox, x, y, width, height, offsetX, offsetY ) {
        
            //Math.floor(x - bbox.left * (width  / bbox.width))
            //Math.floor(y - bbox.top  * (height / bbox.height))
            
       return { x: Math.floor((x - bbox.left) * (width  / bbox.width)),
                y: Math.floor((y - bbox.top)  * (height / bbox.height))
              };
              
    },
    eventHandler: function ( event, cols, rows, offsetX, offsetY ) {
        
        this.coords = [];
        
        var coords = this.mapWindowToCanvas( event.target.getBoundingClientRect() ,event.clientX, event.clientY, cols, rows, offsetX, offsetY );

        if ( event.shiftKey ) {
            
            this.shift = true;
            
        }else{
            
            this.shift = false;
            
        }

        this.leftClick = true;
        
        this.coords.push( coords );
        
        return;
    }
};

function MineSweeper () {

    this.on = true;
    this.tiles = undefined;
    this.ctx = undefined;
    this.map = undefined;
    this.eventLayer = undefined;
    
    this.difficulty = 4;
    this.styleBlock = 'blue';
    this.styleMine = 'mine';
    this.blockKeys = {
                    'blue': 0,
                    'black': 1,
                    'grey': 2,
                    'green': 3,
                    'light-blue': 4,
                    'orange': 5,
                    'red': 6,
                    'purple': 7
                };
    this.actionKeys = {
        'mine': 17,
        'flag': 18,
        'end': 19
    };
    this.neighnorHoodKeys = [
        8,
        9,
        10,
        11,
        12,
        13,
        14,
        15,
        16
    ];
    this.difficultyDict = {
            '7': "easy",
            '4': "medium",
            '2': "hard"
    };

}
MineSweeper.prototype = {
    init: function ( imgs, canvas ) {
        
        this.tiles = imgs;
        this.ctx = canvas.getContext("2d");
        this.eventLayer = new CanvasEventGrid();
        this.map = new CanvasMap( canvas.width, canvas.height );
        this.fillMap();
        this.drawMap();
        
    },
    clear: function () {
        
        this.map.clear("base");
        this.map.clear("stack");
        this.map.clear("heap");
        this.map.clear("flag");
        this.ctx.clearRect(0,0,(this.map.cols*this.map.tileSize),(this.map.rows*this.map.tileSize));

    },
    end: function () {
        
        this.drawMap(false,"base",true,true);
        
        return true;
        
    },
    fillMap: function () {
        
        var numOfMines = (this.map.layers['base'].length / this.difficulty);
        
        for ( var i = 0 ;  i < this.map.layers['base'].length ; i++ ) {
        
            var chance = (numOfMines / this.map.layers['base'].length);
            
            if ( chance  > Math.random() ) {
                
                this.map.layers['base'][i] = this.actionKeys[this.styleMine];
                numOfMines--;
                
            }else {
                
                this.map.layers['base'][i] = 0;
                
            }
        }
        
    },
    drawMap: function ( start = true, layer = 'base', flags = true, end = false ) {
        
        var count = 0;
        
        for ( var i = 0 ;  i < this.map.cols ; i++ ) {
            
            for ( var j = 0 ;  j < this.map.rows ; j++ ) {
            
                var curr = this.map.getValueAt( i, j, layer );
                curr = start === true ? this.blockKeys[this.styleBlock] : curr;
                
                if ( curr == undefined ) {
                    continue;
                }
                
                if ( curr < 0 ) {
                    continue;
                }
                
                if ( end == false && curr == 17 ) {
                    continue;
                } else if ( end == true && curr !== 17) {
                    continue;
                }
                
                if ( flags == false && this.map.getValueAt(i,j,"flag") == 18 ) {
                    continue;
                }
                
                this.ctx.drawImage(
                    this.tiles, // image
                    curr * this.map.tileSize, // source x
                    0, // source y
                    this.map.tileSize, // source width
                    this.map.tileSize, // source height
                    i * this.map.tileSize,  // target x
                    j * this.map.tileSize, // target y
                    this.map.tileSize, // target width
                    this.map.tileSize // target height
                );
                
                count++;
                
            }
        }
        
        return count;
        
    },
    getNeighbors: function ( x, y ) {

        var mines = 0;
        
        mines += this.map.getValueAt((x - 1),(y - 1)) | 0;
        //console.log("mines rnd 1? ", mines);
        mines += this.map.getValueAt(x,(y - 1)) | 0;
        //console.log("mines rnd 2? ", mines);
        mines += this.map.getValueAt((x + 1),(y - 1)) | 0;
        //console.log("mines rnd 3? ", mines);
        mines += this.map.getValueAt((x - 1),y) | 0;
        //console.log("mines rnd 4? ", mines);
        mines += this.map.getValueAt((x + 1),y) | 0;
        //console.log("mines rnd 5? ", mines);
        mines += this.map.getValueAt((x - 1),(y + 1)) | 0;
        //console.log("mines rnd 6? ", mines);
        mines += this.map.getValueAt(x,(y + 1)) | 0;
        //console.log("mines rnd 7? ", mines);
        mines += this.map.getValueAt((x + 1),(y + 1)) | 0;
        //console.log("mines rnd 8? ", mines);
        return Math.round(( mines / this.actionKeys[this.styleMine]) + this.neighnorHoodKeys[0]);
        
    },
    reveal: function ( x, y ) {

            this.recursiveReveal(x - 1,y - 1);
            this.recursiveReveal(x,y - 1);
            this.recursiveReveal(x + 1,y - 1);
            this.recursiveReveal(x - 1,y);
            this.recursiveReveal(x + 1,y);
            this.recursiveReveal(x - 1,y + 1);
            this.recursiveReveal(x,y + 1);
            this.recursiveReveal(x + 1,y + 1);

    },
    recursiveReveal: function ( x, y ) {
        
        var mines = 0;

        if ( this.map.getValueAt(x,y) == undefined || isNaN(this.map.getValueAt(x,y)) ) {

            //console.info("undefined: ",this.map.getValueAt(x,y), x,y);
            return;

        }
        
        if ( this.map.getValueAt(x,y,"stack") ) {

            //console.info("already processed: ", x,y,);
            return;

        }

        mines = this.getNeighbors(x,y);

        if ( isNaN(mines) ) {
            
            return;
            
        }else if ( mines > 8 ) {

            this.map.putValueAt(x,y,true,"stack");
            this.map.putValueAt(x,y,mines,"heap");
            //console.info("mines near: ", x,y,mines);
            return;
            
        }else{
            
            this.map.putValueAt(x,y,true,"stack");
            this.map.putValueAt(x,y,mines,"heap");
            //console.info("is blank at: ", x,y,mines);
            this.reveal(x,y);

        }

    },
    onClick: function ( event ) {

        this.eventLayer.eventHandler(event, this.map.cols, this.map.rows, event.target.offsetLeft, event.target.offsetTop);
        this.map.clear("heap");

        var x, y;

        x = (Math.floor(this.eventLayer.coords[0].x));
        y = (Math.floor(this.eventLayer.coords[0].y));
        //console.info(this.eventLayer.coords,x,y);

        if ( this.eventLayer.shift ) {

            var isFlagged = this.map.getValueAt(x,y,"flag") == 18 ? true : false;

            if ( isFlagged ) {

                this.map.layers["flag"][(y * this.map.cols + x)] = this.blockKeys[this.styleBlock];

            }else {

                this.map.layers["flag"][(y * this.map.cols + x)] = 18;
            }

            this.drawMap(false,'flag');
            return false; 
            
        }else{

            var subject = this.map.getValueAt(x,y);

            if ( subject == this.actionKeys[this.styleMine] ) {

                return this.end();
                
            }else {

                var hasMines = this.getNeighbors(x,y);

                if (  hasMines > 8 ) {

                    //console.info("has mines", x,y, hasMines);
                    this.map.putValueAt(x,y,true,"stack");
                    this.map.putValueAt(x,y,hasMines,"heap");

                }else {

                    this.map.putValueAt(x,y,true,"stack");
                    this.map.putValueAt(x,y,hasMines,"heap");
                    //console.info("begining recursion",x,y);
                    this.reveal( x, y );

                }
                
                return this.drawMap(false, 'heap', false);
                
            }

        }

    },
    setStyle: function ( block ) {
            
            this.styleBlock = block;
            
    },
    setDifficulty: function ( difficulty ) {
        
        this.difficulty = parseInt(difficulty,10);
        
    },
    getScore: function ( score, time ) {
        
        return [
            "score="+score,
            "time="+time,
            "rank="+ this.difficultyDict[this.difficulty]
        ];
    },
    getDifficulty: function () {
        this.difficulty;
    }
};

function timeController ( viewElem ) {
    
    this.id = undefined;
    var view = viewElem;
    var count = 0;
    this.isOn = false;
    var mins = 0;
    var secs = 0;
    
    this.start = function () {
        
        var id = setInterval(onChange, 1000);
        this.id = id;
        this.isOn = true;
    }
    
    this.stop = function ( ) {
        
        if ( this.id ) {
            
            clearInterval(this.id);
            this.isOn = false;
            
        }
    }
    
    function onChange ( ) {
        
        view.value++;
        
    }
    
}