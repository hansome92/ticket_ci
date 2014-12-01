<link rel="stylesheet" type="text/css" href="<?=$base?>css/dashboard/ticket_customisation.css">
<script src="<?=$base?>js/dashboard/jquery.Jcrop.js"></script>
<div class="row extra-padding">
	<div class="col-md-9">
		<div id="cropimage">
			<? // Get the sizes of the image 
				$sizes = getimagesize($base.'uploads/promotion_images/'.$posted_image);
				$width = $sizes[0];
				$height = $sizes[1];
			?>
			<img src="<?=$base?>uploads/promotion_images/<?=$posted_image?>" id="image-to-be-cropped" alt="" />
		</div>

		
	</div>
	<div class="col-md-3">
		<p class="error"></p>
		<form action="<?=$base?>dashboard/newevent/step_four/<?=$event_id?>" method="post" id="cropform">
			<input type="hidden" id="x1" name="x1" required />
			<input type="hidden" id="y1" name="y1" required />
			<input type="hidden" id="x2" name="x2" required />
			<input type="hidden" id="y2" name="y2" required />
			<input type="hidden" id="w" name="w" required />
			<input type="hidden" id="h" name="h" required />
			<input type="hidden" id="ratio" name="ratio" required/>
			<input type="hidden" id="url" name="url" value="<?=$posted_image?>">
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse big-blk-button crop-submit" />
		</form>
		<a href="<?=$base?>dashboard/newevent/step_four/<?=$event_id?>" class="big-blk-button">Cancel</a>
	</div>
</div>
<script>
	var ratio = 1;
	ratio = (<?=$width?> /  $("#image-to-be-cropped").width());
	$( document ).ready(function() {
		$("form").validate();

		ratio = (<?=$width?> /  $("#image-to-be-cropped").width());
		$('#cropimage img').Jcrop({
			onChange:   showCoords,
			onSelect: showPreview,
			minSize: [ (300/ratio), (300/ratio) ],
			maxSize: [ (300/ratio), (300/ratio) ],
			aspectRatio: 1
		});
		$(".crop-submit").click( function(e){
			if( $("#x1").val() != '' && $("#y1").val() != '' && $("#x2").val() != '' && $("#y2").val() != '' && $("#w").val() != '' && $("#h").val() != '' && $("#ratio").val() != ''){
			}
			else{
				$("p.error").html('Select a field in the picture to crop to the correct size.');
				e.preventDefault();
			}
		});
	});
	function showCoords(c){
		ratio = (<?=$width?> /  $("#image-to-be-cropped").width());
		//showPreview(c);
		$('#x1').val( c.x*ratio );
		$('#y1').val( c.y*ratio );
		$('#x2').val( c.x2*ratio );
		$('#y2').val( c.y2*ratio );
		$('#w').val( c.w*ratio );
		$('#h').val( c.h*ratio );
		$('#ratio').val( ratio );
		//console.log( ratio );
		//console.log( 'Width: ' + c.w );
		//console.log( 'Height: ' + c.w );
	}
	function showPreview(coords){}
</script>