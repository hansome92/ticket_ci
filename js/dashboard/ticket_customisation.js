$("#source .draggable").height( $("#source .draggable").width() );
		$( ".draggable" ).draggable({
			connectToSortable: "#sortable",
			helper: "original",
			revert: "invalid"
		});

		$(".onticket").change( function(e){
			$("#source .draggable").height( $("#source .draggable").width() );
			var id = $(this).attr("id");
			if( $("#"+id).is(":checked") ){
				if( $("#source"+id).length == 0 && $("#ticket-piece-"+id).length == 0){
					$("#source").append("<li class='draggable' id='source-"+id+"' style='background: url("+base_url+"uploads/promotion_images/"+$('#sponsorship-id-'+id+' .ticket-image').val()+");'></li>");
					$("#source .draggable").height( $("#source .draggable").width() );
					$( ".draggable" ).draggable({
						connectToSortable: "#sortable",
						helper: "original",
						revert: "invalid"
					});
				}
			}
			else{
				$("#source-"+id).remove();
			}
		});
		$( ".droppable" ).droppable({
			drop: function(e, ui) {
				/*
					First remove the current id if it exists and put it back in the list.
				 */
				if( typeof $(this).attr('id') != 'undefined'){
					var id = $(this).attr('id').replace('ticket-piece-', '');
					var background = $(this).css('background-image');
					$("#source").append("<li class='draggable' id='source-"+id+"'></li>");
					$("#source-"+id).css('background-image', background);
					$("#source .draggable").height( $("#source .draggable").width() );
					$( ".draggable" ).draggable({
						connectToSortable: "#sortable",
						helper: "original",
						revert: "invalid"
					});
				}
				id = $(ui.draggable).attr('id').replace('source-', '');
				$(this).attr("id", 'ticket-piece-'+id);
				$(this).css('background', $(ui.draggable).css('background-image'));
				$(this).css('background-repeat', 'no-repeat');
				$(this).css('background-size', '100%');
				$(ui.draggable).remove();
				$(this).find('.delete').css('display', 'block');
			}
		});
		$( "ul, li" ).disableSelection();
		$(".delete").click(function(){
			if( typeof $(this).parent().attr('id') != 'undefined' && $(this).parent().attr('id') != ''){
				var id = $(this).parent().attr('id').replace('ticket-piece-', '');
				console.log( $(this).parent() );
				if(typeof $('#sponsorship-id-'+id+' .ticket-image').val() == 'undefined'){
					var image = $(this).parent().css('background-image');
				}
				else{
					var image = "url("+base_url+"uploads/promotion_images/"+$('#sponsorship-id-'+id+' .ticket-image').val()+")";
				}

				$("#source").append("<li class='draggable' id='source-"+id+"' style='background: "+image+";'></li>");
				$("#source .draggable").height( $("#source .draggable").width() );
				$( ".draggable" ).draggable({
					connectToSortable: "#sortable",
					helper: "original",
					revert: "invalid"
				});
				$(this).parent().attr('id', '');
				$(this).parent().css('background-image', 'url(../../../images/placeholder.png)');
				$(this).parent().css('background-repeat', 'no-repeat');
				$(this).parent().css('background-size', '100%');
				$(this).css('display', 'none');
			}
		});
		$("#upload-element").change(function(){
			$("#save-edit").click();
		});
		function ajaxFileUpload(){
			$("#loading").ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});
			$.ajaxFileUpload({
					url: base_url+'dashboardajax/postticketelement',
					secureuri: false,
					fileElementId: 'upload-element',
					dataType: 'json',
					data:{event_id: event_id},
					success: function (data, status){
						if(data.result == true){
							$("#source").prepend("<li class='draggable custom-images' id='source-"+data.id+"' style='background: url("+base_url+"uploads/promotion_images/"+data.url+");'></li>");
							$("#source .draggable").height( $("#source .draggable").width() );
							$( ".draggable" ).draggable({
								connectToSortable: "#sortable",
								helper: "original",
								revert: "invalid"
							});
							
						}
						else{
							$(".error#upload-error").html(data.error);
						}
					},
					error: function (data, status, e){
						alert(e);
					}
				}
			)
			return false;
		}
	$( document ).ready(function() {
		$(".submit-button-ticketpieces").click( function(e){
			if( $(this).attr('id') != 'save-preview' ){
				e.preventDefault();
				var clickedId = $(this).attr('id');
				var flag = true; var codeflag = false;
				$.each( $('.ticket-piece'), function(index, value){
					if( typeof $(value).attr('id') != 'undefined' ){
						if( $(this).attr('id') == 'ticket-piece-barcode' ){
							codeflag = true;
						}
						$("#ticket-pieces-form-"+index).val( $(value).attr('id').replace('ticket-piece-', '') );
					}
					else{
						flag = false;
					}
				});
				if(flag == true && codeflag == true){
					$('.error#overall-errors').html('');
					$("#ticketpieces").submit();
				}
				else if(codeflag == false){
					$('.error#overall-errors').html('Barcode hasn\'t been placed on the ticket.');
				}
				else if(clickedId == 'save-edit'){
				console.log(clickedId);
					$('.error#overall-errors').html('');
					$("#ticketpieces").submit();
				}
				else{
					//var confirm = window.confirm("Not every piece on the ticket has been filled yet. If you publish an event like this, there will be a fee of €0,50 per ticket.");
					//if(confirm == true){
						$("#submittype").val('publish');
						$("#ticketpieces").submit();
					//}
					//$('.error#overall-errors').html('Not every piece on the ticket has been filled yet.');
				}
			}
		});
	});