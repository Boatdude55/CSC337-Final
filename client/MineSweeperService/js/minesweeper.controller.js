'use strict';

var MineSweeper = function ( ctx ) {
    
    function Rules ( width, height, xTiles, yTiles, mineProp ) {
    
        this.tileWidth = (width/20);
        this.tileHeight = (height/20);
        this.tilesPerRow = (width/this.tileWidth);
        this.tilesPerCol = (width/this.tileHeight);
        this.fieldSize = (this.tilesPerCol*this.tilesPerRow);
        this.numOfMines = (Math.floor((this.fieldSize)/mineProp));
    }

    function CanvasClass ( canvas ) {
        
        this.canvas = canvas;
        this.ctx2D = canvas.getContext('2d');
        this.ctx3D = canvas.getContext('3d');
        this.children = [];
        
    }
    
    CanvasClass.prototype = {
        broadcast: function ( neighborhood  ) {
            
            var response = 0;
            var myNeighbors = [];
            
            for( var i = 0; i < this.children.length; i++ ) {
                    
                for ( var neighbor in neighborhood ) {
    
                    if ( neighborhood[neighbor].x === this.children[i].x && neighborhood[neighbor].y === this.children[i].y ) {
                        
                        if ( this.children[i].isMine ) {
    
                            response++;
    
                        }else{
    
                            myNeighbors.push(this.children[i]);
                        }
                    }
    
                }
    
            }
    
    
            return [response,myNeighbors];
    
        },
        toggleAll: function ( elem ) {
            
            var curr = this.broadcast( elem.neighbors );
            var adj = curr[0] == 0? false:curr[0]+"";
            
            if ( adj ) {
                
                elem.update(false,adj);
                return;
                
            }else{
                curr[1].forEach( function ( curr ) {
    
                        this.updateAll(curr);
                        
                    
                }, this);
            }
        },
        updateAll: function ( elem ) {
            
            if ( elem.x == undefined || elem.y == undefined ) {
                
                return;
    
            }
            
            if ( elem.state === true ) {
                
                return;
                
            }
            
            var curr = this.broadcast( elem.neighbors );
            var adj = curr[0] == 0? 0:curr[0]+"";
            
            if (adj == 0) {
                
                elem.update(false);
                this.toggleAll(elem);
                
            }else{
                
                elem.update(false,adj);
                return;
                
            }
            
        },
        windowToCanvas: function ( x, y) {
            
           var bbox = this.canvas.getBoundingClientRect();
        
           return { x: x - bbox.left * (this.canvas.width  / bbox.width),
                    y: y - bbox.top  * (this.canvas.height / bbox.height)
                  };
                  
        },
        addChild: function ( child ) {
            
            this.children.push(child);
            
        },
        removeChild: function ( id ) {
            
            this.children = this.children.filter(function (currentValue, index, array) {
                
                if ( currentValue.id !== id ) {
                    return currentValue;
                }
            });
            
        },
        getChildAt: function ( x, y ) {
            
        },
        GameOver: function () {
            
            for ( var i = 0 ; i < this.children.length; i++ ) {
                
                if ( this.children[i].isMine ) {
                    
                    this.children[i].update(true);
                    
                }    
            }
            
        },
        onClick: function ( event ) {
            
            event.preventDefault();
        
            var local= this.windowToCanvas( event.clientX, event.clientY);
    
            for ( var i = 0; i < this.children.length; i++ ) {
                
                if ( this.children[i].isInRegion(local.x, local.y) )  {
    
                    if ( this.children[i].isMine ) {
                        
                        this.children[i].update(true );
                        /**
                         * Property that triggers whatever happens for game over
                         * 
                         * */
                        this.GameOver();
                        return true;
                    }else {
    
                        this.toggleAll(this.children[i]);                            
                        /**
                         * Expecting Update property to be a function
                         * for redrawing the game board based on rules
                         * 
                         * */
                        
                        //this.update();
                        
                    }
                    
                    break;
                    
                }
            }
    
        }
    };

    //function CanvasElement ( x, y, dx, dy, id, mine ) {
    function CanvasElement ( x, y, dx, dy ) {
        this.x = x;
        this.y = y;
        this.dx = dx;
        this.dy = dy;
        this.state = false;
        //this.id = id;
        //this.isTrigger = mine;
    
    }
    CanvasElement.prototype = {
        draw: function ( func ) {
    
            func.call(this);
            
        },
        update: function ( gameover, adj ) {
            
            if ( gameover ) {
                
                this.draw(function () {
                    var img = document.getElementById("mine");
                    ctx.fillStyle = "red";
                    ctx.fillRect(this.x, this.y, this.dx, this.dy)
                    ctx.drawImage(img,this.x+5, this.y+5, this.dx-10, this.dy-10);
                });
                
            }else{
                
                ctx.font = '30px Lucida Console';
                ctx.fillStyle = "white";
                ctx.strokeStyle = "grey";
                ctx.fillRect(this.x, this.y, this.dx, this.dy);
                ctx.strokeRect(this.x, this.y, this.dx, this.dy);
                if ( adj ) {
                    
                    var centeredX = this.x; var centeredY = this.y + (this.dy);
                    ctx.fillStyle = "blue";
                    ctx.fillText(adj, centeredX, centeredY);
                } 
                
                this.state = true;
                
            }
            
        },
        isInRegion: function ( x, y ) {
            
            var isHit = false;
    
            if ( this.x <= x && x <= (this.dx + this.x) ) {
                
                if(this.y <= y && y <= (this.dy + this.y) ) {
                    
                    isHit = true;
                    
                }
                
            }
            
            return isHit;
            
        }
    };
    
    function setUpGame ( Field, seed ) {
        

        for ( var i = 0; i < seed.fieldSize; i++ ) {
            
            var tileID = "tile" + i;
            var x = (i*seed.tileWidth)%Field.canvas.width;
            var y = Math.floor(i/seed.tilesPerRow) * seed.tileHeight;
            var mine = false;
            var chance = seed.numOfMines / (100 - i);
            
            //Makes game too easy but is more consistent in result than probabilty implementation
            var randX = Math.floor(Math.random()*10)*seed.tileWidth;
            var randY = Math.floor(Math.random()*10)*seed.tileHeight;
            
            //if ( Math.random() < chance ) {
            if ( x === randX || y === randY ) {

                mine = true;
                seed.numOfMines--;
                
            }
            
            //var tile = new CanvasElement( x, y, seed.tileWidth, seed.tileHeight, tileID, mine);
            
            var left = (x - seed.tileWidth) < 0? undefined:(x - seed.tileWidth);
            var right = (x + seed.tileWidth) > Field.canvas.width? undefined:(x + seed.tileWidth);
            var up = (y - seed.tileHeight) < 0? undefined:(y - seed.tileHeight);
            var down = (y + seed.tileHeight) > Field.canvas.height? undefined:(y + seed.tileHeight);

            var neighborhood = {
                    ul: {x:left, y:up},
                    um: {x:x,y:up},
                    ur: {x:right,y:up},
                    ml: {x:left,y:y},
                    mr: {x:right,y:y},
                    bl: {x:left, y:down},
                    bm: {x:x,y:down},
                    br: {x:right,y:down}
            };
            
            var tile = Object.create(new CanvasElement(x, y, seed.tileWidth, seed.tileHeight),{
                'isMine': {
                    value: mine,
                    writable: false
                },
                'id':{
                    value: tileID,
                    writable: false
                },
                'neighbors': {
                    value: neighborhood,
                    writable: false
                }
            });
            
            Field.addChild(tile);
            
        }
    }
    
    function initGame ( Field ) {
        
        for ( var i = 0; i < Field.children.length; i++ ) {
        
            Field.children[i].draw(function ( ) {
                
                try{
                    
                    //ctx.fillStyle = "grey";
                    //ctx.strokeStyle = "black";
                    //ctx.fillRect(this.x, this.y, this.dx, this.dy);
                    //ctx.strokeRect(this.x, this.y, this.dx, this.dy);
                    var img = document.getElementById("tile");
                    //ctx.fillStyle = "white";
                    //ctx.fillRect(this.x, this.y, this.dx, this.dy)
                    ctx.drawImage(img,this.x, this.y, this.dx, this.dy);
                }catch ( err ) {
                    
                    var msg = "Error drawing CanvasElem " + this.id + err.message;
                    
                    throw new Error(msg);
                    
                }
            });
            
        }
    }
    
    return {
        Canvas: CanvasClass,
        CanvasElem: CanvasElement,
        rules: Rules,
        setup: setUpGame,
        init: initGame
    };
    
};