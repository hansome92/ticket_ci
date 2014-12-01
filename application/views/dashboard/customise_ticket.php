 <div id="content" class="dashboard-form">
 	<script type="text/javascript" src="<?=$base?>js/dashboard/ajaxupload.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$base?>css/dashboard/ticket_customisation.css">
	<div class="row" id="navigation-row">
		<div class="col-lg-12 col-sm-12 col-md-12 full-block" id="tickets-sold">
			<div class="steps-buttons" id="step-1">
				<a href="<?=$base?>dashboard/newevent/<?=$event['EventID']?>"><div class="step">1</div></a>
				<h2>Event info</h2>
			</div>
			<div class="steps-buttons" id="step-2">
				<a href="<?=$base?>dashboard/event/<?=$event['EventID']?>/tickets"><div class="step">2</div></a>
				<h2>Tickets</h2>
			</div>
			<div class="steps-buttons " id="step-3">
				<a href="<?=$base?>dashboard/newevent/step_two/<?=$event['EventID']?>"><div class="step">3</div></a>
				<h2>Customize event</h2>
			</div>
			<div class="steps-buttons active" id="step-4">
				<a href="<?=$base?>dashboard/newevent/step_four/<?=$event['EventID']?>"><div class="step">4</div></a>
				<h2>Customise ticket</h2>
			</div>
		</div>
	</div>
	<div class="row" id="">
		<div class="col-md-2">
			<h2>Sponsorships<a href="#popup-help" class="popup-help" data-type="help" data-id="52"><img src="<?=$base?>images/questionmark.png" alt="question"></a></h2>
		</div>
		<div class="col-md-2">
			<h2>Drag&amp;Drop<a href="#popup-help" class="popup-help" data-type="help" data-id="53"><img src="<?=$base?>images/questionmark.png" alt="question"></a></h2>
		</div>
		<div class="col-md-8">
			<h2>Ticket<a href="#popup-help" class="popup-help" data-type="help" data-id="54"><img src="<?=$base?>images/questionmark.png" alt="question"></a></h2>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<div class="sponsorship-wrapper">
				<ul><? 
					foreach($sponsorships as $sponsor): 
						if(!isset($sponsor['preferences']['custom']) || $sponsor['preferences']['custom']['Value'] != '1'):
							$flag = false; 
							if(isset($event['eventsponsorpreferences']) && !empty($event['eventsponsorpreferences'])){
								foreach($event['eventsponsorpreferences'] as $chosen_sponsor){
									if(isset($chosen_sponsor['Value']) && $chosen_sponsor['Value'] == $sponsor['ID']){
										$flag = true;
									} 
								}
							}
					?>
						<li id="sponsorship-id-<?=$sponsor['ID']?>">
							<span class="title"><?=$sponsor['preferences']['title']['Value']?></span>
							<span class="description">&euro;<?=$sponsor['preferences']['price']['Value']?></span>
							<input type="checkbox" class="onticket" id="<?=$sponsor['ID']?>" <?=(isset($flag) && $flag == true ? 'checked' : '')?>>
							<input type="hidden" class="ticket-image" value="<?=$sponsor['preferences']['image']['Value']?>" />
						</li>
					<? endif; endforeach;?>
				</ul>
			</div>
		</div>
		<div class="col-md-2">
			<div class="sponsorship-wrapper" id="drag">

				<div class="upload-wrapper"></div>
				<!--<form action="<?=$base?>dashboardajax/postticketelement" method="post" id="ajaxupload">-->
					<a href="#" id="upload-ticket-element" class="upload-button" onclick="$('#upload-element').click();">Upload image<img src="<?=$base?>images/dashboard/icon/upload.png" /></a>
					
					<!--<button class="button" style="display:none;" id="buttonUpload" onclick="">Upload</button>-->
					<p class="error" id="upload-error"><?=(isset($errorupload) && $errorupload != '' ? $errorupload : '')?></p>
					<p>Upload image on the ticket.(jpg, png)</p>
				<!--</form>-->
				<div class="clear-title">
					<h2>ticket elements</h2>
				</div>
				<ul id="source">
					<?
					$barcode_flag = false;
						if(isset($event['eventsponsorpreferences']) && !empty($event['eventsponsorpreferences'])):
							foreach($event['eventsponsorpreferences'] as $sponsors){
								if(isset($sponsors['Value']) && $sponsors['Value'] == 'barcode'){
									$barcode_flag = true;
								}
							}
						endif;
					?>
					<? if(isset($barcode_flag) && $barcode_flag === false):?><li class='draggable custom-images' id='source-barcode' style="background-image:url('<?=$base?>images/dashboard/barcode-placeholder.png');"></li><? endif; ?>
					<? foreach($sponsorships as $sponsor): 
						if(isset($sponsor['preferences']['custom']) && $sponsor['preferences']['custom']['Value'] == '1'):
						$flag = false; 
							if(isset($event['eventsponsorpreferences']) && !empty($event['eventsponsorpreferences'])) {
								foreach($event['eventsponsorpreferences'] as $chosen_sponsor){
									if(isset($chosen_sponsor['Value']) && $chosen_sponsor['Value'] == $sponsor['ID']){
										$flag = true;
									}
								}
							}
						if(!isset($flag) || $flag != true):?><li class='draggable custom-images' id='source-<?=$sponsor['ID']?>' style='background: url(<?=$base?>uploads/promotion_images/<?=(file_exists('./uploads/promotion_images/cropped-'.$sponsor['preferences']['image']['Value']) ? 'cropped-'.$sponsor['preferences']['image']['Value'] : $sponsor['preferences']['image']['Value'] )?>);'></li><? endif; ?>
					<? endif; endforeach; ?>
				</ul>
				
				<img id="loading" src="<?=$base?>images/dashboard/ajax-loader.gif" style="display:none;">
			</div>
		</div>
		<div class="col-md-8">
			<div class="ticket-wrapper" style="padding: 15px 15px 15px 30px; border: 1px solid #000;">
				<div class="row" style="padding:0px 5px;">
					<div class="col-md-12 ticket-header">
						<? if(isset($event['eventscustomisationpreferences']['header_photo']['Value']) && $event['eventscustomisationpreferences']['header_photo']['Value'] != ''):?>
							<? if(file_exists('./uploads/cover_photos/_cropped/'.$event['eventscustomisationpreferences']['header_photo']['Value'])): ?>
								<img src="<?=$base?>uploads/cover_photos/_cropped/<?=$event['eventscustomisationpreferences']['header_photo']['Value']?>" alt="" id="header_pic" />
							<? else: ?>
								<img src="<?=$base?>uploads/cover_photos/_src/<?=$event['eventscustomisationpreferences']['header_photo']['Value']?>" alt="" id="header_pic" />
							<? endif; ?>
						<? elseif(file_exists('./uploads/cover_photos/_cropped/'.$event['EventID'].'.jpg')): ?>
							<img src="<?=$base?>uploads/cover_photos/_cropped/<?=$event['EventID']?>.jpg" alt="" id="header_pic" />
						<? elseif(file_exists('./uploads/cover_photos/_src/'.$event['EventID'].'.jpg')): ?>
							<img src="<?=$base?>uploads/cover_photos/_src/<?=$event['EventID']?>.jpg" alt="" id="header_pic" />
						<? else: ?>
							<div style="border-top:0px solid #000; height: 30px; margin-top:15px;"><h2>Ticket</h2></div>
							<!--<img src="<?=$base?>images/dashboard/dashboard-preview/960x355.gif" alt="" id="header_pic" />-->
						<? endif; ?>
					</div>
				</div>
				<? for($i=0;$i<9;$i++):?>
					<? if($i % 3 == 0): ?> <div class="row" style="padding:0px 15px;"> <? endif; ?>
						<div class="col-md-4">
							<? if(isset($event['eventsponsorpreferences'][$i]['Value']) && $event['eventsponsorpreferences'][$i]['Value'] == 'barcode'): ?>
								<div class="ticket-piece droppable" id="ticket-piece-barcode" style="background-image: url(http://tibbaa.com/dev/images/dashboard/barcode-placeholder.png); background-size: 100%;">
									<div class="delete" style="display:block;">X</div>
								</div>
							<? elseif(isset($event['eventsponsorpreferences'][$i]['preferences']['image']['Value']) && $event['eventsponsorpreferences'][$i]['Value'] != 'barcode'): ?>
								<div class="ticket-piece droppable" id="ticket-piece-<?=$event['eventsponsorpreferences'][$i]['Value']?>" 
									style="background-image: url(
											http://tibbaa.com/dev/uploads/promotion_images/<?=(file_exists('./uploads/promotion_images/cropped-'.$event['eventsponsorpreferences'][$i]['preferences']['image']['Value']) ? 'cropped-'.$event['eventsponsorpreferences'][$i]['preferences']['image']['Value'] : $event['eventsponsorpreferences'][$i]['preferences']['image']['Value'] )?>); background-size: 100%;">
									<div class="delete" style="display:block;">X</div>
								</div>
							<? else: ?>
								<div class="ticket-piece droppable">
									<div class="delete">X</div>
								</div>
							<? endif; ?>
						</div>
					<? if($i % 3 == 2 && $i != 0): ?> </div> <? endif; ?>
				<? endfor; ?>
				<div class="row" style="padding:0px 5px;">
					<div class="col-md-12">
						<p>Ticket powered by Tibbaa.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="clear line"></div>
		<form id="ticketpieces" method="post" action="<?=$base?>dashboard/newevent/step_four/<?=$event['EventID']?>" enctype="multipart/form-data">
			<input type="hidden" name="submittype" id="submittype" value="" />
			<input type="hidden" name="event_id" value="<?=$event['EventID']?>" />
			<input id="upload-element" name="upload-element" type="file"><p id="upload-element-value" style="float: left;"></p>
			<? for ($i=0; $i < 9; $i++):?>
				<input type="hidden" value="" class="ticketpieces" id="ticket-pieces-form-<?=$i?>" name="ticketpieces[]" />
			<? endfor; ?>
			<div class="col-md-12">
				<span class="error" id="overall-errors"></span>
				<input type="submit" class="submit-button-ticketpieces" id="save-edit" name="submit-type" value="Save and edit" />
				<a href="<?=$base?>dashboard/newevent/step_four/<?=$event['EventID']?>/pdf" target="_blank" class="submit-button-ticketpieces" id="save-preview">Preview</a>
				<input type="submit" class="submit-button-ticketpieces" id="save-publish" name="submit-type" value="Publish" />
			</div>
		</form>
	</div>
</div>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="<?=$base?>js/dashboard/ticket_customisation.js"></script>