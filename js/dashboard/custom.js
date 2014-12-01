jQuery(window).ready(function(){
	jQuery(".side-pull").on("click",function(event){
		jQuery("#side-nav").animate({
			"left":"0"
		});
		event.stopPropagation()
	});
	jQuery("#side-nav").on("click",function(event){
		event.stopPropagation()
	});
	
	
	
	
	jQuery("body:not(#side-nav)").on("click",function(){
		jQuery("#side-nav").animate({
			"left":"-100%"
		});
	});
	
	stickyFooter();
	
	
	
	jQuery("#side-nav").find("ul>li>ul").each(function(){
		jQuery(this).parent().prepend("<span class='subpull'></span>");
	});
	
	jQuery(".subpull").on("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
		event.stopPropagation()
	});
	
	jQuery(".pull").on("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
	});


	  jQuery('.scroll-next').on({
    mouseleave: function() {
        clearInterval( $(this).data('timer') );
    },
    mouseenter: function() {
    	var barsWidth = $("#bars").width();
    	var barsMLeft = parseInt($("#bars").css("margin-left").replace("px", ""));
    	var contWidth = $("#bars-container").width();
    	
       
        $(this).data('timer', setInterval(function () {
        	var barsWidth = $("#bars").width();
    		var barsMLeft = parseInt($("#bars").css("margin-left").replace("px", ""));
    		var contWidth = $("#bars-container").width();
    			if (barsWidth + barsMLeft > contWidth) {
            $('#bars').css('margin-left', function (index, curValue) {
		    return parseInt(curValue, 10) - 1 + 'px';
		   
		});
             }
        }, 10));
    
    }

    
});
	   jQuery('.scroll-prev').on({
    mouseleave: function() {
        clearInterval( $(this).data('timer') );
    },
    mouseenter: function() {
        $(this).data('timer', setInterval(function () {
        	console.log($("#bars").css('margin-left') );
        	if ($("#bars").css('margin-left').replace("px", "") < 0) {
            $('#bars').css('margin-left', function (index, curValue) {
		    return parseInt(curValue, 10) + 1 + 'px';

		});
        }
        }, 10));
    }
});
	
});


jQuery(window).scroll(function(){
	var top = jQuery("#top");
	var scrolled = jQuery(document).scrollTop();
	
	if(scrolled>0){
		top.addClass("shadow");
	}else{
		top.removeClass("shadow");
	}
	
});


jQuery(window).resize(function(){
	wwidth = jQuery(window).width();
	if(wwidth>767){
		jQuery("#top nav ul").removeAttr("style");
		jQuery("#footer ul").removeAttr("style");
	}
	
	stickyFooter();
});

// STICKY FOOTER DYNAMIC HEIGHT //
function stickyFooter (){
	var footerHeight = jQuery("#footer").outerHeight();
	jQuery("#footer").css({"marginTop":"-"+footerHeight+"px"});
	jQuery("#wrapper").css({"paddingBottom":footerHeight+50+"px"}); // FOOTER HEIGHT + EXTRA SPACING (50px)

}

/* Horizontal graph bars */
jQuery(document).ready(function() {
	var bars = $(".bar-horizontal").length;
	var count = bars;
		function initHorizontalBars() {
			jQuery.each(
	    	$(".bar-horizontal"), 
	    	function(index, bar) {
	    	if ($(bar).is(":empty")) {
	    	var total = $(bar).data("tickets-max");
	    	var sold = $(bar).data("tickets-sold");
	    	var checkedin = $(bar).data("tickets-checked-in");
	    	var title = $(bar).data("event-title");
	    	var id = $(bar).data("event-id");

	    	var soldP = (sold-checkedin)/total*100;
	    	var checkedinP = checkedin/total*100;

	    	$(bar).wrap("<div class='bar-slide' />");

	    	$(bar).parent().prepend("<a href='"+base_url+"dashboard/event/"+id+"/tickets'>Ticket management</a><h3>"+title+"</h3>")
	    	$(bar).append("<div class='checkedin hastip' title='"+checkedin+" tickets checked-in'></div>");
	    	$(bar).append("<div class='sold hastip' title='"+sold+" tickets sold'></div>");

	    	$(bar).find(".sold").animate({width:soldP+"%"},1000, function() {
	    		
	    	});
	    	$(bar).find(".checkedin").animate({width:checkedinP+"%"},1000);

	    	//$('.hastip').tooltipsy();
	    	if (!--count) showSlider();
	    	}
	    });
	}
    $('.hastip').tooltipsy();
    function showSlider() {
	    var Slider = $('#event-overview-slider').bxSlider({
	    	mode: "vertical",
	    	minSlides: 4,
	    	maxSlides: 4,
	    	pager: false,
	    	controls: false
	    });

	    $(".events-overview-slide-prev").click(function() {
	    	Slider.goToNextSlide();
	    	initHorizontalBars();
	    });
    }

    initHorizontalBars();
    //$(".tooltipsy").wrap("<div class='tooltip-top' />")

})