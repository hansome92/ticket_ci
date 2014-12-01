<div id="content" class="dashboard-form">
	<div class="row" id="navigation-row">
		<div class="col-lg-12 col-sm-12 col-md-12 full-block" id="tickets-sold">
			<div class="steps-buttons active" id="step-1">
				<?if(isset($event['EventID'])):?><a href="<?=$base?>dashboard/newevent/<?=$event['EventID']?>"><? endif; ?>
					<div class="step">1</div>
				<?if(isset($event['EventID'])):?></a><? endif; ?>
				<h2>Event info</h2>
			</div>
			<div class="steps-buttons" id="step-2">
				<?if(isset($event['EventID'])):?><a href="<?=$base?>dashboard/event/<?=$event['EventID']?>/tickets"><? endif; ?>
					<div class="step">2</div>
				<?if(isset($event['EventID'])):?></a><? endif; ?>
				<h2>Tickets</h2>
			</div>
			<div class="steps-buttons " id="step-3">
				<?if(isset($event['EventID'])):?><a href="<?=$base?>dashboard/newevent/step_two/<?=$event['EventID']?>"><? endif; ?>
					<div class="step">3</div>
				<?if(isset($event['EventID'])):?></a><? endif; ?>
				<h2>Customize event</h2>
			</div>
			<div class="steps-buttons" id="step-4">
				<?if(isset($event['EventID'])):?><a href="<?=$base?>dashboard/newevent/step_four/<?=$event['EventID']?>"><? endif; ?>
					<div class="step">4</div>
				<?if(isset($event['EventID'])):?></a><? endif; ?>
				<h2>Customize ticket</h2>
			</div>
		</div>
	</div>
	<div class="row" id="">
		<div class="col-md-6">
			<h2>Event</h2>
		</div>
	</div>
	<form action="<?=$base?>dashboard/newevent<?=(isset($event['EventID']) ? '/'.$event['EventID'] : '')?>" id="page-form" method="post" enctype="multipart/form-data">
		<? if(isset($event['EventID'])):?>
			<input type="hidden" name="event_id" value="<?=$event['EventID']?>" />
		<? endif;?>
		<div class="row">
			<div class="col-md-6">
				<div class="left">Event name <a href="#popup-help" class="popup-help" data-type="help" data-id="25"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<textarea id="eventname" style="display:none;"><?=$event['eventName']?></textarea>
				<div class="right">
					<input <? if(isset($event['EventID'])):?> <? endif; ?> required type="text" name="eventname" id="eventname" value="<?=(isset($event['EventName']) ? $event['EventName'] : '' )?>">
				</div>
			</div>
			<? if(!isset($event['EventID'])): ?>
				<div class="col-md-6 right-col">
					<a href="#" class="facebook-import-button" onclick="$('.forced-popup').click();">Import Facebook event</a>
				</div>
			<? endif; ?>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="left">Description<a href="#popup-help" class="popup-help" data-type="help" data-id="26"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<textarea required name="description" id="description" rows="10"><?=(isset($event['preferences']['description']['Value']) ? $event['preferences']['description']['Value'] : '' )?></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="left">Event type<a href="#popup-help" class="popup-help" data-type="help" data-id="27"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<div class="big-select">
						<select required class="big-select" id="eventtype" name="eventtype">
							<option>Select type event</option>
							<? foreach ($eventtypes as $key => $value): ?>
								<option value="<?=$value['ID']?>" <?if(isset($event['preferences']['eventtype']['Value']) && $event['preferences']['eventtype']['Value'] == $value['ID']):?>selected<? endif; ?>><?=$value['Type']?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-6">
				<div class="left">Tags<a href="#popup-help" class="popup-help" data-type="help" data-id="28"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" class="tags-input" id="tags" name="tags" data-default="Add tags" value="<?=(isset($event['preferences']['tags']['Value']) ? $event['preferences']['tags']['Value'] : '' )?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 location-inputs">
				
				<div class="left">Venue<a href="#popup-help" class="popup-help" data-type="help" data-id="29"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" id="venue" name="venue" value="<?=(isset($event['preferences']['venue']['Value']) ? $event['preferences']['venue']['Value'] : '' )?>">
				</div>
				<div class="clear"></div>
				<div class="left">Address<a href="#popup-help" class="popup-help" data-type="help" data-id="30"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" id="address" class="map_change" name="address" value="<?=(isset($event['preferences']['address']['Value']) ? $event['preferences']['address']['Value'] : '' )?>">
				</div>
				<div class="clear"></div>
				<div class="left">City<a href="#popup-help" class="popup-help" data-type="help" data-id="31"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" id="city" class="map_change" name="city" value="<?=(isset($event['preferences']['city']['Value']) ? $event['preferences']['city']['Value'] : '' )?>">
				</div>
					<div class="clear"></div>
				<div class="left">Country<a href="#popup-help" class="popup-help" data-type="help" data-id="32"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" id="country" class="map_change" name="country" value="<?=(isset($event['preferences']['country']['Value']) ? $event['preferences']['country']['Value'] : '' )?>">
				</div>
					<div class="clear"></div>
				<div class="left">Location<a href="#popup-help" class="popup-help" data-type="help" data-id="33"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<input required type="text" id="location" class="map_change" name="location" value="<?=(isset($event['preferences']['location']['Value']) ? $event['preferences']['location']['Value'] : '' )?>">
				</div>
			</div>
			<div class="col-md-6 right-column">
				<div id="map-canvas"></div>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_mniQi7IwaxqW9mrWaFYgjqF8n2Q-1OU&sensor=true" type="text/javascript"></script>
			</div>
		</div>
		<div class="row">
			<div class="clear line"></div>
			<div class="col-md-12">
				<h2>Period</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 date-row">
				<div class="left">Date<a href="#popup-help" class="popup-help" data-type="help" data-id="34"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					<span class="label">From</span>
					<input required type="text" name="start_date" id="start_date" class="datepicker" value="<?=(isset($event['preferences']['start_date']['Value']) ? $event['preferences']['start_date']['Value'] : date('d/m/Y'))?>">
					<span class="label">To</span>
					<input required type="text" name="end_date" id="end_date" class="datepicker" value="<?=(isset($event['preferences']['end_date']['Value']) ? $event['preferences']['end_date']['Value'] : date('d/m/Y') )?>">
				</div>
			</div>
			<div class="col-md-12 date-row" style="margin-top:25px;">
				<div class="left">Time<a href="#popup-help" class="popup-help" data-type="help" data-id="35"><img src="<?=$base?>images/questionmark.png" alt="question"></a></div>
				<div class="right">
					
					<span class="label">From</span>
					<input required type="text" name="start_time" id="start_time" class="timepicker" value="<?=(isset($event['preferences']['start_time']['Value']) ? $event['preferences']['start_time']['Value'] : date('G:i') )?>" />
					<span class="label">To</span>
					<input required type="text" name="end_time" id="end_time" class="timepicker"  value="<?=(isset($event['preferences']['end_time']['Value']) ? $event['preferences']['end_time']['Value'] : date('G:i') )?>" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="clear line"></div>
			<div class="col-md-12">
				<input type="submit" value="Next step" />
			</div>
		</div>
	</form>
</div>