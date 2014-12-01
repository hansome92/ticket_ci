jQuery(window).ready(function(){
	jQuery(".pull").on("click",function(){
		jQuery(this).next().slideToggle();
	});
	
	stickyFooter();
	
	
	
	jQuery("#top").find("nav>ul>li>ul").each(function(){
		jQuery(this).parent().prepend("<span class='subpull'></span>");
	});
	
	jQuery(".subpull").on("click", function(){
		jQuery(this).parent().find("ul").slideToggle();
	});

	jQuery("#ordertickets .nextstep").click(function(){
		jQuery(this).parent().parent().hide();
		jQuery(this).parent().parent().next().show();
		jQuery("#steps").find(".active").removeClass("active").parent().next().find("h2").addClass("active");
	});

	jQuery("#ordertickets .prevstep").click(function(){
		jQuery(this).parent().parent().hide();
		jQuery(this).parent().parent().prev().show();
		jQuery("#steps").find(".active").removeClass("active").parent().prev().find("h2").addClass("active");
	});

	
	
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
	jQuery("#wrapper").css({"paddingBottom":footerHeight+"px"}); // FOOTER HEIGHT + EXTRA SPACING (50px)

}