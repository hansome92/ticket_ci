var checkforshared = false;
$( document ).ready(function() {
	
	$('form').validate();
	/*
		Trigger ajax lost password
	 */
	$("#forgot-password-form").submit( function(e){
		e.preventDefault();
		if( $("#forgot-password-form").valid() == true ){
			$.post( base_url+"ajax/sendpassword",  $(this).serialize() )
				.done(function( data ) {
					data = eval('('+data+')');
					console.log(data);
					if(data['result'] == true){
						$('#pass-lost-result').html( 'A new password has been sent to your emailaddress.' );
					}
					else{
						$('#pass-lost-result').html(data['error']);
						$('#pass-lost-result').addClass('error');
					}
			  });
		}
		else{
			$('#pass-lost-result').html( data['error'] );
			$('#pass-lost-result').addClass('error');
		}
	});
	/************************************
			Trigger ajax login function
	************************************/
	$("#loginform, #loginform-mobile").submit( function(e){
		e.preventDefault();
		$.post( base_url+"ajax/login",  $(this).serialize() )
			.done(function( data ) {
				data = eval('('+data+')');
				if(data['result'] == true){
					window.location = base_url+'dashboard';
				}
				else{
					$('#login .error').html(data['error']);
					$('#login .error').css('display', 'block');
				}
		  });
	});
	/************************************
		Trigger ajax register function
	************************************/
	$("#registerform, #registerform-mobile").submit( function(e){
		e.preventDefault();
		if( $("#registerform").valid() == true ){
			$.post( base_url+"ajax/register",  $(this).serialize() )
				.done(function( data ) {
					data = eval('('+data+')');
					if(data['result'] == true){
						window.location = base_url+'dashboard';
					}
					else{
						$('#signup .error').html(data['error']);
						$('#signup .error').css('display', 'block');
					}
			  });
		}
		else{
			$('#signup .error').html( data['error'] );
			$('#signup .error').css('display', 'block');
		}
	});
	/************************************
			Ajaxlogin with Facebook
	************************************/
	$("#facebooklogin").click(function(e){
		e.preventDefault;
		$.post( base_url+"ajax/fblogin", {id: $("#facebooklogin").attr('data-id')})
		  .done(function( data ) {
		  });
	});
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
					$("#admin-fee").html( data.administration_fee_after_shared );
					$("#paymentAmount").val( data.new_total );
					$("#total-visible-price").html( data.new_total_formatted );
					$("#merchantSig").val( data.new_merch_key );
					$("#sessionValidity").val( data.sessionValidity );

					checkforshared = false;
				}
			});
		}
	}, 3500);
});
function checkFBTrue(){
	checkforshared = true;
}
