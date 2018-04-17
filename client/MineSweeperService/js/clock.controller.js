'use strict';

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
                    
                    }
                }
                
                function onChange ( ) {
                    
                    view.innerHTML++;
                    
                }
                
            }