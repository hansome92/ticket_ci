$( document ).ready(function() {
	$.each( colors, function(key, value){
		changeColors(value[0], value[1], key);
	});
});
function changeColors(id, hex){
	if(id == 'background-top-color' || id == 'background-bottom-color'){
		var topColor = backgroundtopcolor;
		var bottomColor = backgroundbottomcolor;
		$("body").css('background', '#'+topColor); /* Old browsers */
		$("body").css('background', '-moz-linear-gradient(top,  #'+topColor+' 0%, #'+bottomColor+' 100%)');
		$("body").css('background', '-webkit-gradient(linear, left top, left bottom, color-stop(0%,#'+topColor+'), color-stop(100%,#'+bottomColor+'))');
		$("body").css('background', '-webkit-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("body").css('background', '-o-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("body").css('background', '-ms-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("body").css('background', 'linear-gradient(to bottom,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("body").css('background', 'progid:DXImageTransform.Microsoft.gradient( startColorstr=#'+topColor+', endColorstr=#'+bottomColor+',GradientType=0 )');
		$("body").css('background-size', '100%');
		$("body").css('background-attachment', 'fixed');
	}
	else{
		$("."+id+"-background").css('background-color', '#'+hex);
		$("."+id+"-text").css('color', '#'+hex);
	}
}
