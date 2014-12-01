<script type="text/javascript">
var geocoder;
var map;
var marker;
var checkforshared = false;
$( document ).ready(function() {

	$(".js-price-input, .ensurance-input").change(function() {
		//Update total
		var totalPrice = 0;

		$(".js-ticket-row").each(function (i, v){
			numTickets = $(v).find(".js-price-input").val();
			var newPrice = $(v).find(".js-price-default").html().replace(",", ".") * numTickets;
			if(isNaN(newPrice) == true){
				newPrice = 0;
			}
			totalPrice += newPrice;
			$(v).find(".js-price-result").text(newPrice.toFixed(2).replace(".", ","));
		});
		var ensuranceCost = (totalPrice/10);
		$(".ensurance-value").text(ensuranceCost.toFixed(2).replace(".", ","));
		if(ensuranceCost == 0){
			$("#ensurance-row").css('display', 'none');
		}
		else{
			$("#ensurance-row").css('display', 'table-row');
		}
		if( $("#ensurance-yes").is(':checked') == true ){
			$(".js-price-total").text((totalPrice+ensuranceCost).toFixed(2).replace(".", ","));
		}
		else{
			$(".js-price-total").text((totalPrice).toFixed(2).replace(".", ","));
		}
		
	});
	$.each( colors, function(key, value){
		changeColors(value[0], value[1]);
	});
	$('.basic, .form-select, .big-select').fancySelect();

	$("#upload-logo").change(function(){
		$('#upload-logo-value').html( $("#upload-logo").val().replace("C:\\fakepath\\", "") );
	});

	$('#page-form').validate();
	$('form').validate();
	/*
		Changing selectbox and getting new genres through ajax
	 */
	$("#sign-up").click(function(e){
		e.preventDefault();
		$("#sign-up-form").animate({
			height: [ "toggle", "swing" ]
		}, 1000);
	});
	$("#eventtype").change(function(){
		$.post( base_url+"dashboardajax/getdropdownsubtypes", { chosen_id: $("#eventtype").val() })
		  .done(function( data ) {
		  	data = eval('('+data+')');
		  	var dropdown = '<div class="big-select"><select class="big-select" id="event-sub-type">';
			$.each( data.options, function(key, value){
				dropdown += '<option value="'+key+'">'+value+'</option>';
			})
			dropdown += '</select></div>';
		  	$("#subtype-dropdown").html( dropdown );
			$('.big-select').fancySelect();
			$('#subtype-dropdown').parent().parent().css('display', 'block');
		  });
	});
	/*
		Add/remove tickettype to table
	 */
	$("#add-ticket").click(function(e){
		e.preventDefault();

		$("#edit-tickets-table tbody").append('<tr><td class="ticketname"><input type="text" name="tickets[tickets-name][0][]" id="tickets[tickets-name][0][]"></td><td class="capacity"><input type="text" name="tickets[tickets-capacity][0][]" id="tickets[tickets-capacity][0][]"></td><td class="ppt"><input type="text" name="tickets[tickets-ppt][0][]" id="tickets[tickets-ppt][0][]"></td><td><a href="#" class="edit-button" id="substract-row" onclick="removeTicketRow(this, event);"><img src="'+base_url+'images/dashboard/icon/substract.png" /></a></td></tr>');
	});

	$("#tickets-form").submit(function(e){
		var flag = false;
		$.each( $("#edit-tickets-table tbody tr"), function(){
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
		});
		if(flag == true){
			e.preventDefault();
		}
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
	/*
		Login
	 */
	$(".blue-btn").click(function(e){

		if( $(this).attr('id') == 'loginform-submit' ){
			e.preventDefault();
			$("#loginform").submit();
		}
	});
	$("#loginform").submit( function(e){
		e.preventDefault();
		$.post( base_url+"ajax/login",  $("#loginform").serialize() )
			.done(function( data ) {
				data = eval('('+data+')');
				if(data['result'] == true){
					location.reload();
				}
				else{
					$('#login-error').html(data['error']);
					$('#login-error').css('display', 'block');
				}
		  });
	});
	$("#registerform-submit").click( function(e){
		e.preventDefault(); 
		if($("#emailaddress").val() != $("#re-emailaddress").val() && $("#emailaddress").val() != '' && $("#re-emailaddress").val() != '' ){
			$("#signup-error").html('The entered email addresses do not match.');
		}
		else if( $("#registerform").valid() == true){
			$.post( base_url+"ajax/registerticketbox",  $("#registerform").serialize() )
				.done(function( data ) {
					data = eval('('+data+')');
					if(data['result'] == true){
						location.reload();
					}
					else{
						$('#login-error').html(data['error']);
						$('#login-error').css('display', 'block');
					}
			});
		}
		else{
			$("#signup-error").html('Some fields do not match the criteria.');
		}
	});
	var meta = '<?=(isset($meta) ? $meta : "") ?>';
	$(".next-step").click(function(e){
		e.preventDefault;
		if($("form").valid() == true  && checkMinimumTickets() == true && checkIfEnsuranceIsChosen() == true){
			$.post( base_url+"order/"+meta+"/"+$(this).attr("current-step"), $("form").serialize() )
				.done(function( data ) {
			 		$(".ticketbox").html(data);
			});
		}
		else if(checkMinimumTickets() != true){
			$("#valide").html('No tickets have been chosen.');
		}
		else if(checkIfEnsuranceIsChosen() != true){
		}
		else{

		}
		return false;
	});

	/*
		Step 2 data
	 */
	$(".next-step-data-buyers").click( function(e){
		e.preventDefault();
		if($("form").valid() == true){
			$.post( base_url+"order/"+meta+"/"+$(this).attr("current-step"), $("form").serialize() )
				.done(function( data ) {
			 		$(".ticketbox").html(data);
			 		//console.log(data);
			});
		}
	});
	/*
		Cancel order
	 */
	$(".cancel-order").click(function(e){
		e.preventDefault();
		var r = confirm("Are you sure you want to cancel your order?");
		if(r == true){
			$.post( base_url+"order/"+meta+"/cancel")
				.done(function( data ) {
			 		$(".ticketbox").html(data);
			});
		}
	});
	/*
		End of step 2
	 */
	setInterval(function(){
		if(checkforshared == true){
			$(".facebook-row td:first-child .loading").css('display', 'block');
			$.post( base_url+"ajax/checkiffbshared", {meta: meta, orderid: $('#merchantReference').val()})
			.done(function( data ) {
				$(".facebook-row td:first-child .loading").css('display', 'none');
				data = eval('('+data+')');
				if(data.result == true){
					/************************************
							Edit prices in DOM model
					************************************/
					$("#paymentAmount").val( data.new_total );
					$("#total-visible-price").html( data.new_total_formatted );
					$("#shared-field").html(data.administration_fee_after_shared);
					$(".payment-submit").attr('href', data.new_url);

					checkforshared = false;
				}
			});
		}
	}, 3500);
});
/*
	Remove ticket row
 */
function removeTicketRow(element, event){
	event.preventDefault();
	$(element).parent().parent().remove();	
}
/*
	Changing color functions
 */
function changePreset(preset){
	for(var index in preset){
		changeColors(index, preset[index]);
		$('#'+index+'-hex').val(preset[index].replace( '#', '' ));
		$('#'+index+' i').css('background', preset[index]);
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

function codeAddress() {
	if( $(this).attr('id') != 'location' ){
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
					$("#address").val( results[0].address_components[0].long_name );
					$("#city").val( results[0].address_components[2].long_name );
					$("#country").val( results[0].address_components[4].long_name );
					$("#location").val( results[0].geometry.location );
				}
				else{
					$("#address").val( results[0].address_components[1].long_name + ' ' + results[0].address_components[0].long_name );
					$("#city").val( results[0].address_components[4].long_name );
					$("#country").val( results[0].address_components[6].long_name );
					$("#location").val( results[0].geometry.location );
				}
			});
		}
	}
}

function checkFBTrue(){
	checkforshared = true;
}
/*
Check if ensurance is selected
 */
function checkIfEnsuranceIsChosen(){
	var count = 0;
	$("input:radio[name=cancel-ensurance]").each(function (i, v){
		count++;
	});
	if(count == 0){
		return true;
	}
	var n = $("input:radio[name=cancel-ensurance]:checked").val();
	if(!n){
		$("#ensurance-row").addClass("error");
		return false;
	}
	else{
		return true;
	}
}
/*
	Function to check if theres selected a ticket
 */
function checkMinimumTickets(){
	var total = 0; var count = 0;
	$(".js-price-input").each(function (i, v){
		if(parseInt($(v).val()) != 'NaN'){
			var numTickets = parseInt($(v).val());
			total = (total+numTickets);
			count++;
		}
		else{
			return false;
		}
	});
	if(count <= 0){
		return true;
	}
	if(total > 0){
		return true;
	}
	return false;
}
$( document ).ready(function() {
	$("#facebooklogin-tickets").click(function(e){
		e.preventDefault;
		$.post( base_url+"ajax/fblogin", {id: $("#facebooklogin-tickets").attr('data-id'), refresh: true})
		  .done(function( data ) {
			alert(data);
		  });
	});
	$("#loginform-tickets").submit(function(e){
		if($("#loginform-tickets").valid() == true){
			$.post( base_url+"ajax/login", $("#loginform-tickets").serialize())
			  .done(function( data ) {
			  	data = eval('('+data+')');
			  	if(data['result'] == true){
			  		location.reload();
			  	}
			  	else{
			  		$('#loginform-tickets .error').html( data.error );
			  	}
			});
		}
		else{
			$('#loginform-tickets .error').html('Vul de velden in.');
		}
		return false;
		e.preventDefault;
	});
	/*
		Delete a row of tickets from oversight
	 */
	$('.delete-ticket').click(function(e){
		if( confirm("Delete "+$(this).attr('data-name')+" from order?") == true){
			var id = $(this).attr('data-id');

			$.post( base_url+"ajax/deleteticketfromorder", { ticketid : id })
			  .done(function( data ) {
			  	data = eval('('+data+')');
			  	if(data['result'] == true){
			  		$("#data-row-"+id).remove();
			  	}
			});
		}
		e.preventDefault();
	});
	$("#fb-share-button").click(function(){
		checkforshared = true;
	});
	$(".plus").click(function(e){
		e.preventDefault();
		var targetID = 'target-textbox-'+$(this).attr('data-id');
		var value = $('#'+targetID).val( );
		value++;
		$('#target-textbox-span-'+$(this).attr('data-id')).html(value);
		$('#'+targetID).val(value);
		$('#'+targetID).change();
	});
	$(".minus").click(function(e){
		e.preventDefault();
		var targetID = 'target-textbox-'+$(this).attr('data-id');
		var value = $('#'+targetID).val( );
		if(value > 0){
			value--;
			$('#target-textbox-span-'+$(this).attr('data-id')).html(value);
			$('#'+targetID).val(value);
			$('#'+targetID).change();
		}

	});
});
</script>