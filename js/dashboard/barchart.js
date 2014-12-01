(function( $ ){

    var methods = {
        init : function(options) {
            var max = 0;
            for (var i = 0; i < options.length; i++) {
                if (options[i][1] > max) {
                    max = options[i][1];
                }
            }

            var nullen = parseInt(max.toString().length) - 2;
            var y = 1;
            for (x = 0; x < nullen; x++) {
                var y = y + "0";
            }

            var y = parseInt(y);

            var top = Math.ceil(max/y)*y;


            var parts = Math.ceil((top/6)/y)*y;
            var top = parts*6;

            for (i = 6; i >= 0; i--) {
                $("#barchart #y-axis").append("<span>"+parts*i+"</span>");
            }

            $("#barchart #bars").height($("#barchart #y-axis").height());

            for (i = 0; i < options.length; i++) {
                $("#barchart #x-axis").append();
                var percentage = options[i][1] / top * 100;
                $("#barchart #bars").append("<div class='bar-container'><div class='bar'><div class='bar-value hastip' title='"+options[i][1]+" tickets' style='height:"+percentage+"%;display:none;'></div></div><span>"+options[i][0]+"</span></div>");
            }

            if (options.length < 12) {
                var width = (($("#barchart").outerWidth() - $("#y-axis").outerWidth()) - 3) / options.length;
            } else {
                var width = ($("#barchart").outerWidth() - $("#y-axis").outerWidth()) / 12;
            }
            //console.log(width);
            //console.log($("#bars").outerWidth());
            //console.log($("#bars").outerWidth() / 12);
            //console.log(width);

            $("#barchart #bars .bar").width(0.5*width).css({marginLeft:0.26*width,marginRight:0.26 * width});

            $("#barchart #bars .bar-value").each(function(index, bar) {

                var height = $(bar).height();
                $(bar).height(0).show().animate({height: height}, 2000);

            })

            $("#barchart #bars").width(options.length * $(".bar-container").outerWidth() + 0.27*width);

            $("#bars").css({
                marginLeft: ($("#bars").width() - $("#bars-container").width())*-1+5
            })
        }   
    };

    $.fn.barChart = function(methodOrOptions) {
        if ( methods[methodOrOptions] ) {
            return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  methodOrOptions + ' does not exist on jQuery.barChart' );
        }    
    };

  

})( jQuery );