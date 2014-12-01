var geocoder;
var map;
var marker;
$( document ).ready(function() {
	$(".confirm-delete").click(function(e){
		var r = confirm("Are you sure you want to delete this event?");
		if(r == false){
			e.preventDefault();
		}
		else{
			return r;
		}
	});
	$('.agreement').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$.post( base_url+"dashboardajax/saveanswer", {popupid: $("#popup-id").val(), answer: id})
		  .done(function( data ) {
		  	location.reload();
		  });
	});
	$('.fb_event').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		if(id == 'agree'){
			if( $("#facebook_event").val() != '' ){
				$("form#post-facebook-event-form").submit();
			}
			else{
				$("#facebook-event-error").html('Not a valid Facebook event.');
			}
		}
		else{
			/*$.post( base_url+"dashboardajax/savenotofacebookevent")
			  .done(function( data ) {
			  	
			});*/
			$.fancybox.close();
		}
	});

	$('.price-input').on('change',function(){
		console.log('Change event.');
		var val = $(this).val();
		$(this).val( val !== '' ? val : '(empty)' );
		console.log(val);
	});
	$('.price-input').number( true, 2 );

	$('.basic, .form-select, .big-select').fancySelect();

	$("#upload-logo").change(function(){
		$('#upload-logo-value').html( $("#upload-logo").val().replace("C:\\fakepath\\", "") );
	});
	$("#upload-header").change(function(){
		$('#upload-header-value').html( $("#upload-header").val().replace("C:\\fakepath\\", "") );
	});
	$("#upload-element").change(function(){
		$('#upload-element-value').html( $("#upload-element").val().replace("C:\\fakepath\\", "") );
	});

	$( ".datepicker" ).datepicker();
	$.datepicker.setDefaults( { dateFormat: 'dd/mm/yy' } );
	$("#start_date").change( function(){
		var date = $(this).val().split('/');
		var x=new Date(date[2], --date[1], date[0]);
		/*
			Get end date
		 */
		var date = $("#end_date").val().split('/');
		var y=new Date(date[2], --date[1], date[0]);
		/*
			Compare values
		 */
		if(x>y){
			$("#end_date").val( x.getDate()+'/'+(x.getMonth()+1)+'/'+x.getFullYear() );
		}
	} );
	$('.timepicker').timepicker({
		showMeridian : false
	});
	$('.tags-input').tagsInput();
	$('#page-form').validate();
	/*
		Add/remove tickettype to table
	 */
	$("#add-ticket").click(function(e){
		e.preventDefault();
		if( $(".ticket-wrapper:last-child").hasClass('odd') == true){
			var elementClass= "";
		}
		else{
			var elementClass = "odd";
		}

		var rand_id = Math.floor((Math.random()*1000)+1);
		$(".tickets-wrapper").append('<div class="row ticket-wrapper '+elementClass+'"><div class="col-md-12"><div class="row general-inputs"><div class="col-md-3"><input type="text" name="tickets[tickets-name][0][]" placeholder="Ticketname"></div><div class="col-md-3"><input type="text" name="tickets[tickets-capacity][0][]" placeholder="Capacity"></div><div class="col-md-3 ppt-col"><div class="big-select"><select required class="big-select" id="eventtype" name="eventtype"><option value="EUR">&euro;</option><option value="USD">$</option><option value="CNY">&yen;</option><option value="GBP">&pound;</option></select></div><input type="text" value="" name="tickets[tickets-ppt][0][]" placeholder="Price(#,###.##)" class="price-input"></div><div class="col-md-3"><div class="edit-button substract-row"><a href="#" class="edit-button substract-row" onclick="removeTicketRow(this, event);"><img src="'+base_url+'images/dashboard/icon/substract.png" /></a></div><div class="edit-button"><a href="#" class="expand-button">Expand</a></div><a href="#popup-help" class="popup-help" data-type="help" data-id="36"><img src="'+base_url+'images/questionmark.png" alt="question"></a></div></div><div class="row ticket-options"><div class="col-md-12"><div class="row"><div class="col-md-12"><span>Partial access during event<a href="#popup-help" class="popup-help" data-type="help" data-id="37"><img src="'+base_url+'images/questionmark.png" alt="question"></a></span><input type="checkbox" class="partial-access-check" value="1" name="tickets[tickets-partial-access][0][]" /></div></div><div class="row partial-access-option"><div class="col-md-6"><div class="slider-range" id="slider-id-'+rand_id+'" data-id="'+rand_id+'"></div></div><div class="col-md-6"><input type="hidden" name="tickets[partial-access-start][0][]" id="from-time-value-'+rand_id+'" value=""><input type="hidden" name="tickets[partial-access-end][0][]" id="end-time-value-'+rand_id+'" value=""><span class="time-indication" id="from-time-'+rand_id+'"></span><span class="time-indication" id="end-time-'+rand_id+'"></span></div></div><div class="row"><div class="col-md-12"><span>Designated seating<a href="#popup-help" class="popup-help" data-type="help" data-id="38"><img src="'+base_url+'images/questionmark.png" alt="question"></a></span><input type="checkbox" class="designated-seating-check" value="1" name="tickets[designated-seating-access][0][]" /></div></div><div class="row designated-seating-option"><div class="col-md-12"><span>Row indicators</span></div></div><div class="row designated-seating-option"><div class="col-md-12"><input type="radio" name="tickets[row-indicator][0][]" id="row-indicator-option-'+rand_id+'-1" value="1"><label for="row-indicator-option-'+rand_id+'-1">Numbers</label><input type="radio" name="tickets[row-indicator][0][]" id="row-indicator-option-'+rand_id+'-2" value="2"><label for="row-indicator-option-'+rand_id+'-2">Characters</label></div></div><div class="row designated-seating-option"><div class="col-md-12"><span class="range">Range</span><input type="text" class="range-input" name="tickets[row-range-start][0][]"><span class="range">&nbsp;-&nbsp;</span><input type="text" class="range-input" name="tickets[row-range-end][0][]"></div></div><div class="row designated-seating-option"><div class="col-md-12"><span>Chair number</span></div></div><div class="row designated-seating-option"><div class="col-md-12"><input type="radio" name="tickets[chair-indicator][0][]" id="designated-seating-option-'+rand_id+'-1" value="1"><label for="designated-seating-option-'+rand_id+'-1">Numbers</label><input type="radio" name="tickets[chair-indicator][0][]" id="designated-seating-option-'+rand_id+'-2" value="2"><label for="designated-seating-option-'+rand_id+'-2">Characters</label></div></div><div class="row designated-seating-option"><div class="col-md-12"><span class="range">Range</span><input type="text" class="range-input" name="tickets[chair-range-start][0][]"><span class="range">&nbsp;-&nbsp;</span><input type="text" class="range-input" name="tickets[chair-range-end][0][]"></div></div><div class="row"><div class="col-md-12 border-top"><span class="range">Ticketfee(per ticket)<a href="#popup-help" class="popup-help" data-type="help" data-id="39"><img src="'+base_url+'images/questionmark.png" alt="question"></a></span></div></div><div class="row"><div class="col-md-12"><span class="range">Non-shared</span><input type="text" class="range-input price-input" name="tickets[fb-unshared-ticketfee][0][]"><span class="range">&nbsp;shared&nbsp;</span><input type="text" class="range-input price-input" name="tickets[fb-shared-ticketfee][0][]"></div></div><div class="row"><div class="col-md-12 border-top"><span class="range">Offer ensurance on tickets?<a href="#popup-help" class="popup-help" data-type="help" data-id="40"><img src="'+base_url+'images/questionmark.png" alt="question"></a></span></div></div><div class="row"><div class="col-md-12"><input type="radio" name="tickets[offer-ensurance][0][]" id="offer-ensurance-option-'+rand_id+'-1" value="1" class="ensurance-option"><label for="offer-ensurance-option-'+rand_id+'-1">Yes</label><input type="radio" name="tickets[offer-ensurance][0][]" id="offer-ensurance-option-'+rand_id+'-2" value="2" class="ensurance-option"><label for="offer-ensurance-option-'+rand_id+'-2">No</label></div></div></div></div></div></div>');
		/*
			Reinitiate code for new rows
		 */
		
		$('.price-input').on('change',function(){
			console.log('Change event.');
			var val = $(this).val();
			$(this).val( val !== '' ? val : '(empty)' );
			console.log(val);
		});
		$('.price-input').number( true, 2 );
		$('.big-select').fancySelect();
		$(".slider-range#slider-id-"+rand_id).slider({
		    range: true,
		    min: eventStart,
		    max: eventEnd,
		    values: [eventStart, eventEnd],
		    step:300,
		    slide: slideTime
		});
		x = new Date(eventStart*1000);
		y = new Date(eventEnd*1000);
		$("#from-time-"+rand_id).html( '<span class="time">' + ('0'+x.getHours()).slice(-2) + ':' + ('0'+x.getMinutes()).slice(-2) + '</span><span class="date">' + x.getDate()+'/'+(x.getMonth()+1)+'/'+x.getFullYear() +'</span>' );
		$("#end-time-"+rand_id).html( '<span class="time">' + ('0'+y.getHours()).slice(-2) + ':' + ('0'+y.getMinutes()).slice(-2) + '</span><span class="date">' + y.getDate()+'/'+(y.getMonth()+1)+'/'+y.getFullYear() +'</span>' );
		$("#from-time-value-"+rand_id).val( x.getTime()/1000 );
		$("#end-time-value-"+rand_id).val( y.getTime()/1000 );

		$(".designated-seating-check").change(function(){
			if( $(this).is(':checked') == true ){
				$(this).parent().parent().parent().find('.designated-seating-option').animate({'height': 'show'});
			}
			else{
				$(this).parent().parent().parent().find('.designated-seating-option').animate({'height': 'hide'});
			}
		});

		$(".partial-access-check").change(function(){
			if( $(this).is(':checked') == true ){
				$(this).parent().parent().parent().find('.partial-access-option').animate({'height': 'show'});
			}
			else{
				$(this).parent().parent().parent().find('.partial-access-option').animate({'height': 'hide'});
			}
		});

		$(".general-inputs").click(function(){
			if( $(this).parent().find('.ticket-options').css('display') == 'none' ){
				$('.ticket-options').animate({'height': 'hide'});
				$(this).parent().find('.ticket-options').animate({'height': 'show'});
			}
		});

		$(".expand-button").click(function(e){
			e.preventDefault();
			if( $(this).parent().parent().parent().parent().find('.ticket-options').css('display') == 'block' ){
				//$(this).parent().parent().parent().parent().find('.ticket-options').css('display', 'none');
				$(this).parent().parent().parent().parent().find('.ticket-options').animate({'height': 'hide'});
			}
		});

	});
	$(".general-inputs").click(function(){
		if( $(this).parent().find('.ticket-options').css('display') == 'none' ){
			$('.ticket-options').animate({'height': 'hide'});
			$(this).parent().find('.ticket-options').animate({'height': 'show'});
		}
	});

	$(".expand-button").click(function(e){
		e.preventDefault();
		if( $(this).parent().parent().parent().parent().find('.ticket-options').css('display') == 'block' ){
			//$(this).parent().parent().parent().parent().find('.ticket-options').css('display', 'none');
			$(this).parent().parent().parent().parent().find('.ticket-options').animate({'height': 'hide'});
		}
	});
	/*
		Initiate slider and other settings on ticket page
	 */
	$.each( $(".slider-range"), function(index, element){
		$(element).slider({
			range: true,
			min: eventStart,
			max: eventEnd,
			values: [$(element).attr('data-cur-min'), $(element).attr('data-cur-max')],
			step: 300,
			slide: slideTime
		});
		x = new Date(eventStart*1000);
		y = new Date(eventEnd*1000);
		$("#from-time-"+$(element).attr('data-id')).html( '<span class="time">' + ('0'+x.getHours()).slice(-2) + ':' + ('0'+x.getMinutes()).slice(-2) + '</span><span class="date">' + x.getDate()+'/'+(x.getMonth()+1)+'/'+x.getFullYear() +'</span>' );
		$("#end-time-"+$(element).attr('data-id')).html( '<span class="time">' + ('0'+y.getHours()).slice(-2) + ':' + ('0'+y.getMinutes()).slice(-2) + '</span><span class="date">' + y.getDate()+'/'+(y.getMonth()+1)+'/'+y.getFullYear() +'</span>' );
		$("#from-time-value-"+$(element).attr('data-id')).val( x.getTime()/1000 );
		$("#end-time-value-"+$(element).attr('data-id')).val( y.getTime()/1000 );

	})
	$(".designated-seating-check").change(function(){
		if( $(this).is(':checked') == true ){
			$(this).parent().parent().parent().find('.designated-seating-option').animate({'height': 'show'});
		}
		else{
			$(this).parent().parent().parent().find('.designated-seating-option').animate({'height': 'hide'});
		}
	});

	$(".partial-access-check").change(function(){
		if( $(this).is(':checked') == true ){
			$(this).parent().parent().parent().find('.partial-access-option').animate({'height': 'show'});
		}
		else{
			$(this).parent().parent().parent().find('.partial-access-option').animate({'height': 'hide'});
		}
	});
	/*
		On startup, check if all checkboxes are checked or not
	 */
	$.each( $(".designated-seating-check"), function(index, element){
		if( $(element).is(':checked') == true ){
			$(element).parent().parent().parent().find('.designated-seating-option').animate({'height': 'show'});
		}
	} );
	$.each( $(".partial-access-check"), function(index, element){
		if( $(element).is(':checked') == true ){
			$(element).parent().parent().parent().find('.partial-access-option').animate({'height': 'show'});
		}
	} );
	/*
		On submit of the tickets
	 */
	$("#upload-header").change(function(){
		$("#customise-ticket-form-element").append('<input type="hidden" name="header-change" value="yes">');
		$("#customise-ticket-form-element").submit();
	});
	$("#tickets-form").submit(function(e){
		var flag = false;
		$(".error-list").html('');
		$.each( $(".ticket-wrapper"), function(){

			if( $(this).children('.ticketname').children("input").val() != '' ){

				if( $(this).children('.capacity').children("input").val() == '' ){
					$(this).children('.capacity').children("input").toggleClass('error');
					flag = true;
				}
				if( $(this).children('.ppt').children("input").val() == '' ){
					$(this).children('.ppt').children("input").toggleClass('error');
					flag = true;
				}
			}
			var radioName = $(this).find("input:radio:checked").val();
			if( typeof radioName == 'undefined' ){
				$(this).children('.ppt').children("input").toggleClass('error');
				$(".error-field").css('display', 'block');
				$(".error-list").append('<li>Ensurance</li>');
				flag = true;
			}
		});
		if(flag == true){
			e.preventDefault();
		}
	});
	/*
		Google maps part
	 */
	if(typeof(google) != 'undefined'){
		var map = initialize();
		$(".map_change").change( codeAddress );
	}
	/*
		Preset fixes
	*/
	var id = $("#preset-dropdown").val();
	if(typeof(presetArray) == 'object'){
		changePreset(presetArray[id]);
		$("#preset-dropdown").change(function(){
			var id = $("#preset-dropdown").val();
			changePreset(presetArray[id]);
		});
	}

    /*
    	initiate 
     */
	$.each( $(".color"), function(key, value){
		var id = $(value).attr('id');
		var presetColor = $('#'+id+'-hex').val();
		if(presetColor == '' || typeof presetColor != 'undefined'){
			presetColor = 'fff';
		}
		$('#'+id).ColorPicker({
			color: '#'+presetColor,
			onShow: function (colpkr){
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr){
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb){
				$('#'+id+' i').css('backgroundColor', '#' + hex);
				$('#'+id+'-hex').val(hex.replace('#', ''));
				changeColors(id, hex, '');
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor('#'+presetColor);
			}
		});
	});
	$(".colorcode").change(function(){
		var color = $(this).val();
		$(this).parent().find("i").css('background-color', '#'+color);
		changeColors($(this).attr('id').replace('-hex', ''), $(this).val(), '');
	});
	/*
		Get the FB header when it is changed
	 */
	$("#fb_header").change( function(){
		$.post( base_url+"dashboardajax/get_fb_header", { fb_event_id: $(this).val(), event_id: $("#event_id").val() })
		.done(function( data ) {
		  	data = eval('('+data+')');
		  	$("#header_pic").attr('src', data.url);
		});
	});
	$("#address").change();
});
/*
	Remove ticket row
 */
function removeTicketRow(element, event){
	event.preventDefault();
	$(element).parent().parent().parent().parent().parent().remove();

	$.each( $(".ticket-wrapper"), function( index, element ){
		if( index % 2 == 0 ){
			if( $(element).hasClass("odd") == false ){
				$(element).toggleClass("odd");
			}
		}
		else{
			if( $(element).hasClass("odd") == true ){
				$(element).toggleClass("odd");
			}
		}
	});
}
/*
	Changing color functions
 */
function changePreset(preset){
	for(var index in preset){
		changeColors(index, preset[index], preset);
		$('#'+index+'-hex').val(preset[index].replace( '#', '' ));
		$('#'+index+' i').css('background', preset[index]);
	}
}
function changeColors(id, hex, preset){
	if(id == 'background-bottom-color' || id == 'background-top-color'){
		if(preset == '' && $("#background-top-color-hex").val() != '' || preset == '' && $("#background-bottom-color-hex").val() != ''){
			var topColor = $("#background-top-color-hex").val();
			var bottomColor = $("#background-bottom-color-hex").val();
		}
		else{
			var topColor = preset['background-top-color'].replace('#', '');
			var bottomColor = preset['background-bottom-color'].replace('#', '');
		}
		$("#dashboard-event-preview").css('background', '#'+hex); /* Old browsers */
		$("#dashboard-event-preview").css('background', '-moz-linear-gradient(top,  #'+topColor+' 0%, #'+bottomColor+' 100%)');
		$("#dashboard-event-preview").css('background', '-webkit-gradient(linear, left top, left bottom, color-stop(0%,#'+topColor+'), color-stop(100%,#'+bottomColor+'))');
		$("#dashboard-event-preview").css('background', '-webkit-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("#dashboard-event-preview").css('background', '-o-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("#dashboard-event-preview").css('background', '-ms-linear-gradient(top,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("#dashboard-event-preview").css('background', 'linear-gradient(to bottom,  #'+topColor+' 0%,#'+bottomColor+' 100%)');
		$("#dashboard-event-preview").css('background', 'progid:DXImageTransform.Microsoft.gradient( startColorstr=#'+topColor+', endColorstr=#'+bottomColor+',GradientType=0 )');
	}
	else{
		$("."+id+"-background").css('background-color', '#'+hex);
		$("."+id+"-text").css('color', '#'+hex);
	}
}

/*
	Google maps functions
 */
function initialize() {
	if(typeof(google) != 'undefined'){
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		var mapOptions = {
			zoom: 8,
			center: latlng
		}
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	}
}

function codeAddress( ) {
	if( $(this).attr('id') != 'location' || typeof $(this).attr('id') == 'undefined' ){
		var address = $("#city").val() + ' ' + $("#address").val() + ' ' + $("#country").val();
	}
	else{
		var address = '';
	}
	if($(this).val() != ''){
		if($("#address").val() != '' || $("#city").val() != '' || $("#country").val() != '' || $("#location").val() != ''){
			geocoder.geocode( { 'address': address }, function(results, status) {
				console.log(results);
				if (status == google.maps.GeocoderStatus.OK) {

					map.setCenter(results[0].geometry.location);

					map.setZoom(12);

					if(marker){
						marker.setPosition(results[0].geometry.location);
					}
					else{
						marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location
						});
					}
				} else {
					console.log('Geocode was not successful for the following reason: ' + status);
				}
				if( results[0].address_components[0].types[0] == 'route' ){
					if($("#address").val() == ''){
						$("#address").val( results[0].address_components[0].long_name );
					}
					if($("#city").val() == ''){
						$("#city").val( results[0].address_components[2].long_name );
					}
					if($("#country").val() == ''){
						$("#country").val( results[0].address_components[4].long_name );
					}
					if($("#location").val() == ''){
						$("#location").val( results[0].geometry.location );
					}
				}
				else{

					if($("#address").val() == ''){
						$("#address").val( results[0].address_components[1].long_name + ' ' + results[0].address_components[0].long_name );
					}
					if($("#city").val() == ''){
						$("#city").val( results[0].address_components[4].long_name );
					}
					if($("#country").val() == ''){
						$("#country").val( results[0].address_components[6].long_name );
					}
					if($("#location").val() == ''){
						$("#location").val( results[0].geometry.location );
					}

				}
			});
		}
	}
}