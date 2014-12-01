jQuery(window).ready(function(){
	jQuery(".pull").on("click",function(){
		jQuery(this).next().slideToggle();
	});
	
	stickyFooter();
	
	jQuery("#contact").on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({scrollTop: jQuery("#section4").offset().top}, 1100);
	})

	jQuery("#to_one").on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({scrollTop: jQuery("#section1").offset().top-114}, 1100);
	})

	jQuery("#to_three").on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({scrollTop: jQuery("#section3").offset().top-114}, 1100);
	})

	jQuery("#to_two").on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({scrollTop: jQuery("#section2").offset().top-114}, 1100);
	})

	jQuery("#to_four").on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({scrollTop: jQuery("#section4").offset().top-114}, 1100);
	})
	
	jQuery("#top").find("nav>ul>li>ul").each(function(){
		jQuery(this).parent().prepend("<span class='subpull'></span>");
	});
	
	jQuery(".subpull").on("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
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
	
	
	// DYNAMIC TOP HEIGHT ON SCROLL //
	if(scrolled>79) {
		//top.addClass("scrolledheight");
		top.css({
			"height":"114px",
			"lineHeight":"114px"
		});
	}else {
		top.css({
			"height":"114px",
			"lineHeight":"114px"
		});
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
	jQuery("#wrapper").css({"paddingBottom":footerHeight+0+"px"}); // FOOTER HEIGHT + EXTRA SPACING (50px)

}