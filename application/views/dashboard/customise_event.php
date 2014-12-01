<? //echo '<xmp>'; print_r($event ); echo '</xmp>';exit(); ?>
<script type="text/javascript">
	/*
		Set presetarray
	 */
	var presetArray = new Array();
	<? if(isset($event['eventscustomisationpreferences']['steps-color'])):?>
		presetArray[0] = [];
		presetArray[0]['primary-color'] = '#<?=$event["eventscustomisationpreferences"]["primary-color"]["Value"]?>';
		presetArray[0]['primary-text-color'] = '#<?=$event["eventscustomisationpreferences"]["primary-text-color"]["Value"]?>';
		presetArray[0]['text-color'] = '#<?=$event["eventscustomisationpreferences"]["text-color"]["Value"]?>';
		presetArray[0]['ticketbox-color'] = '#<?=$event["eventscustomisationpreferences"]["ticketbox-color"]["Value"]?>';

		presetArray[0]['steps-color'] = '#<?=$event["eventscustomisationpreferences"]["steps-color"]["Value"]?>';
		presetArray[0]['subtext-color'] = '#<?=$event["eventscustomisationpreferences"]["subtext-color"]["Value"]?>';
		presetArray[0]['event-background-color'] = '#<?=$event["eventscustomisationpreferences"]["event-background-color"]["Value"]?>';

		presetArray[0]['background-top-color'] = '#<?=$event["eventscustomisationpreferences"]["background-top-color"]["Value"]?>';
		presetArray[0]['background-bottom-color'] = '#<?=$event["eventscustomisationpreferences"]["background-bottom-color"]["Value"]?>';
	<? endif; ?>
	<? if(isset($presets) && !empty($presets)): $i = 0; foreach($presets as $preset): $i++; ?>
		presetArray[<?=$i?>] = new Array();
		presetArray[<?=$i?>]['primary-color'] = '#<?=$preset["preferences"]["primary-color"]["Value"]?>';
		presetArray[<?=$i?>]['primary-text-color'] = '#<?=$preset["preferences"]["primary-text-color"]["Value"]?>';

		presetArray[<?=$i?>]['text-color'] = '#<?=$preset["preferences"]["text-color"]["Value"]?>';
		presetArray[<?=$i?>]['ticketbox-color'] = '#<?=$preset["preferences"]["ticketbox-color"]["Value"]?>';

		presetArray[<?=$i?>]['steps-color'] = '#<?=$preset["preferences"]["steps-color"]["Value"]?>';
		presetArray[<?=$i?>]['subtext-color'] = '#<?=$preset["preferences"]["subtext-color"]["Value"]?>';
		presetArray[<?=$i?>]['event-background-color'] = '#<?=$preset["preferences"]["event-background-color"]["Value"]?>';

		presetArray[<?=$i?>]['background-top-color'] = '#<?=$preset["preferences"]["background-top-color"]["Value"]?>';
		presetArray[<?=$i?>]['background-bottom-color'] = '#<?=$preset["preferences"]["background-bottom-color"]["Value"]?>';
	<? endforeach; endif; ?>
		presetArray[99999] = [];
		presetArray[99999]['primary-color'] = '#';
		presetArray[99999]['primary-text-color'] = '#';
		presetArray[99999]['text-color'] = '#';
		presetArray[99999]['ticketbox-color'] = '#';

		presetArray[99999]['steps-color'] = '#';
		presetArray[99999]['subtext-color'] = '#';
		presetArray[99999]['event-background-color'] = '#';

		presetArray[99999]['background-top-color'] = '#';
		presetArray[99999]['background-bottom-color'] = '#';
</script>
<div id="content" class="event-customisation-form">
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
			<div class="steps-buttons active" id="step-3">
				<a href="<?=$base?>dashboard/newevent/step_two/<?=$event['EventID']?>"><div class="step">3</div></a>
				<h2>Customize event</h2>
			</div>
			<div class="steps-buttons" id="step-4">
				<a href="<?=$base?>dashboard/newevent/step_four/<?=$event['EventID']?>"><div class="step">4</div></a>
				<h2>Customize ticket</h2>
			</div>
		</div>
	</div>

	<div class="row" id="">
		<div class="col-md-12 full-block">
			<h2>Customize your tickets page</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<form action="<?=$base?>dashboard/newevent/step_two/<?=$event['EventID']?>" method="post" id="customise-ticket-form-element" enctype='multipart/form-data'>
				<input type="hidden" name="event_id" id="event_id" value="<?=$event['EventID']?>" />
				<div class="row">
					<div class="col-md-12 triple-color-row">
						<div class="select big-select color-preset-select">
							<select id="preset-dropdown" class="form-select">
								<? if(isset($event['eventscustomisationpreferences']['steps-color'])):?>
									<option value="0" selected><?=$event['EventName']?></option>
								<? endif; ?>
								<? if(isset($presets) && !empty($presets)): $i = 0; foreach($presets as $preset): $i++; ?>
									<option value="<?=$i;?>" <?=(!isset($event['eventscustomisationpreferences']['steps-color']) && $i == 0 ? 'selected' : '')?> ><?=$preset['PresetName']?></option>
								<? endforeach; endif; ?>
								<option value="99999">Custom</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="left">Upload an header image<a href="#popup-help" class="popup-help" data-type="help" data-id="42"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<!--<input type="text" name="fb_header" id="fb_header">
							<span class="or">or</span>-->
							
							<!--<form action="<?=$base?>dashboardajax/posteventheader" method="post" id="ajaxupload">
								<a href="#" class="upload-button" onclick="$(this).parent().children('#upload-element').click();">Upload image<img src="<?=$base?>images/dashboard/icon/upload.png" /></a>
								<input id="upload-element" name="upload-element" type="file"><p id="upload-element-value" style="float: left;"></p>
								<button class="button" style="display:none;" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button>
							</form>-->
							<a href="#" class="upload-button" onclick="$(this).parent().children('#upload-header').click();">Upload header<img src="<?=$base?>images/dashboard/icon/upload.png" /></a>
							<input id="upload-header" name="upload-header" type="file"><p id="upload-header-value" style="float: left;"></p>
							<? if(isset($uploaderror)):?><p class="error"><?=$uploaderror?></p><? endif; ?>
							<!--<a href="#" class="upload-button" onclick="$(this).parent().children('#upload-avatar').click();">Upload avatar<img src="<?=$base?>images/dashboard/icon/upload.png" /></a>
							<input id="upload-avatar" type="file">-->

						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Primary color<a href="#popup-help" class="popup-help" data-type="help" data-id="43"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="primary-color"><i></i></div><input name="primary-color" id="primary-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Primary text color<a href="#popup-help" class="popup-help" data-type="help" data-id="44"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="primary-text-color"><i></i></div><input name="primary-text-color" id="primary-text-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Main text color<a href="#popup-help" class="popup-help" data-type="help" data-id="45"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="text-color"><i></i></div><input name="text-color" id="text-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Subtext color<a href="#popup-help" class="popup-help" data-type="help" data-id="46"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="subtext-color"><i></i></div><input name="subtext-color" id="subtext-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Table color<a href="#popup-help" class="popup-help" data-type="help" data-id="47"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="ticketbox-color"><i></i></div><input name="ticketbox-color" id="ticketbox-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Steps color<a href="#popup-help" class="popup-help" data-type="help" data-id="48"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="steps-color"><i></i></div><input name="steps-color" id="steps-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Event background color<a href="#popup-help" class="popup-help" data-type="help" data-id="49"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="event-background-color"><i></i></div><input name="event-background-color" id="event-background-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Background top color<a href="#popup-help" class="popup-help" data-type="help" data-id="50"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="background-top-color"><i></i></div><input name="background-top-color" id="background-top-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
					<div class="col-md-12 triple-color-row">
						<div class="left">Background bottom color<a href="#popup-help" class="popup-help" data-type="help" data-id="51"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
						<div class="right">
							<div class="color" id="background-bottom-color"><i></i></div><input name="background-bottom-color" id="background-bottom-color-hex" type="text" class="colorcode" required />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9" id="dashboard-event-preview">
				<div class="preview-wrapper">
					<div class="preview-header">
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
							<img src="<?=$base?>images/dashboard/dashboard-preview/960x355.gif" alt="" id="header_pic" />
						<? endif; ?>
					</div>
					<div class="preview-row event-background-color-background">
						<div class="steps">
							<div class="step active">
								<span class="step-number primary-color-background primary-text-color-text">1</span><span class="step-title text-color-text">Tickets</span>
							</div>
							<div class="step">
								<span class="step-number steps-color-background text-color-text">2</span><span class="step-title text-color-text">Personal info</span>
							</div>
							<div class="step">
								<span class="step-number steps-color-background text-color-text">3</span><span class="step-title text-color-text">Confirmation</span>
							</div>
							<div class="step">
								<span class="step-number steps-color-background text-color-text">4</span><span class="step-title text-color-text">Payment</span>
							</div>
						</div>
					</div>
					<div class="preview-row event-background-color-background">
						<div class="left">
							<p class="introduction text-color-text">Order your tickets for <?=$event['EventName']?> now!</p>
							<table class="event-info">
								<tr>
									<td class="text-color-text">Event:</td>
									<td class="event-info-node event-title subtext-color-text"><?=$event['EventName']?></td>
									<td class="text-color-text">Date:</td>
									<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['start_date']['Value']) ? $event['preferences']['start_date']['Value'] : '')?></td>
								</tr>
								<tr>
									<td class="text-color-text">Venue:</td>
									<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['venue']['Value']) ? $event['preferences']['venue']['Value'].', ' : '')?> <?=(isset($event['preferences']['city']['Value']) ? $event['preferences']['city']['Value'].', ' : '')?></td>
									<td class="text-color-text">Event time:</td>
									<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['start_time']['Value']) ? $event['preferences']['start_time']['Value'].', ' : '')?> - <?=(isset($event['preferences']['end_time']['Value']) ? $event['preferences']['end_time']['Value'] : '')?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="preview-row event-background-color-background">
						<table id="ticketinfo">
							<thead>
								<tr>
									<th class="primary-color-background primary-text-color-text">Ticket</th>
									<th class="primary-color-background primary-text-color-text">Price</th>
									<th class="first-step-amount primary-color-background primary-text-color-text">Amount</th>
									<th class="primary-color-background primary-text-color-text">Totaal</th>
								</tr>
							</thead>
							<tbody>
								<? $total = 0; if(empty($event['tickets'])): ?>
									<tr class="js-ticket-row">
										<td class="text-color-text ticketbox-color-background">Normal</td>
										<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-default">60,00</span></td>
										<td class="first-step-amount text-color-text ticketbox-color-background">
											<a href="#" class="yellowbtn-plus-minus minus" data-id="2" onclick="return false;"></a>
											<span class="js-price" id="target-textbox-2">0</span>
											<a href="#" class="yellowbtn-plus-minus plus" data-id="2" onclick="return false;"></a>
										</td>
										<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-result">0,00</span></td>
									</tr>
									<? $ensuranceFlag = true; ?>
								<? else: ?>
									<? foreach ($event['tickets'] as $key => $value): ?>
										<tr class="js-ticket-row">
											<td class="text-color-text ticketbox-color-background"><?=$value['preferences']['tickets-name']['Value']?></td>
											<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-default"><?=_getFormattedNumber($value['preferences']['tickets-ppt']['Value'])?></span></td>
											<td class="first-step-amount text-color-text ticketbox-color-background">
												<a href="#" class="yellowbtn-plus-minus minus" data-id="2" onclick="return false;"></a>
												<span class="js-price" id="target-textbox-2">2</span>
												<a href="#" class="yellowbtn-plus-minus plus" data-id="2" onclick="return false;"></a>
											</td>
											<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-result"><?=(_getFormattedNumber($value['preferences']['tickets-ppt']['Value']*2))?></span></td>
										</tr>
										<? if( isset($value['preferences']['offer-ensurance']['Value']) && $value['preferences']['offer-ensurance']['Value'] == 1 ){ $ensuranceFlag = true;} $total = (isset($total) ? $total + $value['preferences']['tickets-ppt']['Value']*2 : $value['preferences']['tickets-ppt']['Value']*2);?>
									<? endforeach; ?>
								<? endif; ?>
							</tbody>
							<tfoot>
								<? if(isset($ensuranceFlag) && $ensuranceFlag == true):?>
									<tr>
										<td colspan="3" class="text-color-text" style="text-align:right;">
											Cancellation ensurance for <span class="ensurance-value" style="display:inline; float:none;">&euro;<?=_getFormattedNumber($total/10)?><? $total += ($total / 10); ?></span> on your tickets.
										</td>
										<td>
											<input type="radio" name="cancel-ensurance" id="ensurance-yes" class="" value="yes" checked onclick="return false;" /><label class="text-color-text" for="ensurance-yes">Yes</label>
											<input type="radio" name="cancel-ensurance" id="ensurance-no" value="no" onclick="return false;" /><label class="text-color-text" for="ensurance-no">No</label>
										</td>
									</tr>
								<? endif; ?>
								<tr>
									<td colspan="3">
										<span class="text-color-text">Subtotal</span>
									</td>
									<td class="text-color-text">&euro; <?=_getFormattedNumber($total)?></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="clear line"></div>
			<div class="col-md-12">
				<input type="submit" id="save-edit" name="submit-type" value="Save and edit" />
				<input type="submit" value="Next step" />
			</div>
		</div>
	</form>