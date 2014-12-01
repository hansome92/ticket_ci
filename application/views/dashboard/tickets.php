<div id="content" class="dashboard-form ticket-form">
	<div class="row" id="navigation-row">
		<div class="col-lg-12 col-sm-12 col-md-12 full-block" id="tickets-sold">
			<div class="steps-buttons" id="step-1">
				<a href="<?=$base?>dashboard/newevent/<?=$event['EventID']?>"><div class="step">1</div></a>
				<h2>Event info</h2>
			</div>
			<div class="steps-buttons active" id="step-2">
				<a href="<?=$base?>dashboard/event/<?=$event['EventID']?>/tickets"><div class="step">2</div></a>
				<h2>Tickets</h2>
			</div>
			<div class="steps-buttons" id="step-3">
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
		<div class="col-md-12">
			<h2><?=$event['EventName']; ?> - Tickets</h2>
		</div>
	</div>
	<form action="<?=$base?>dashboard/event/<?=$event['EventID']?>/tickets" id="tickets-form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="new-tickets" value="<?=$event['EventID']?>" />
		<div class="row">
			<div class="col-md-12">
			<div class="tickets-wrapper">
				<? 
					$i = 0;
					if(!empty($event['tickets'])): 
						foreach ($event['tickets'] as $key => $ticket):
							$i++;
							if(isset($ticket['preferences'])): 
								$prefs = $ticket['preferences'];
				?>
						<div class="row ticket-wrapper <?=($i%2==1 ? 'odd' : '' )?>">
							<div class="col-md-12">
								<div class="row general-inputs">
									<div class="col-md-3"><input type="text" value="<?=$prefs['tickets-name']['Value']?>" name="tickets[tickets-name][<?=$ticket['ID']?>]" placeholder="Ticketname"></div>
									<div class="col-md-3"><input type="text" value="<?=$prefs['tickets-capacity']['Value']?>" name="tickets[tickets-capacity][<?=$ticket['ID']?>]" placeholder="Capacity"></div>
									<div class="col-md-3 ppt-col">
										<div class="big-select">
											<select required class="big-select" id="eventtype" name="eventtype">
												<option value="EUR">&euro;</option>
												<option value="USD">$</option>
												<option value="CNY">&yen;</option>
												<option value="GBP">&pound;</option>
											</select>
										</div>
										<input type="text" value="<?=$prefs['tickets-ppt']['Value']?>" name="tickets[tickets-ppt][<?=$ticket['ID']?>]" placeholder="Price(#,###.##)" class="price-input">
									</div>
									<div class="col-md-3">
										<div class="edit-button substract-row">
											<a href="#" class="edit-button substract-row" onclick="removeTicketRow(this, event);">
												<img src="<?=$base?>images/dashboard/icon/substract.png" />
											</a>
										</div>
										<div class="edit-button">
											<a href="#" class="expand-button">
												Expand
											</a>
										</div>
										<a href="#popup-help" class="popup-help" data-type="help" data-id="36"><img src="<?=$base?>images/questionmark.png" alt="question"></a>
									</div>
								</div>
								<div class="row ticket-options">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-12">
												<span>Partial access during event<a href="#popup-help" class="popup-help" data-type="help" data-id="37"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
												<input type="checkbox" class="partial-access-check" value="1" name="tickets[tickets-partial-access][<?=$ticket['ID']?>]" <?=(isset($prefs['tickets-partial-access']['Value']) && $prefs['tickets-partial-access']['Value'] == '1' ? 'checked' : '')?> />
											</div>
										</div>
										<div class="row partial-access-option">
											<div class="col-md-6">
												<div class="slider-range" data-id="<?=$ticket['ID']?>" data-cur-min="<?=(isset($prefs['partial-access-start']['Value']) ? $prefs['partial-access-start']['Value'] : date('U', strtotime(str_replace('/', '-', $event['preferences']['start_date']['Value'].' '.$event['preferences']['start_time']['Value'])))  )?>" data-cur-max="<?=(isset($prefs['partial-access-end']['Value']) ? $prefs['partial-access-end']['Value'] : date('U', strtotime(str_replace('/', '-', $event['preferences']['end_date']['Value'].' '.$event['preferences']['end_time']['Value']))))?>"></div>
											</div>
											<div class="col-md-6">
												<input type="hidden" name="tickets[partial-access-start][<?=$ticket['ID']?>]" id="from-time-value-<?=$ticket['ID']?>" value="<?=(isset($prefs['partial-access-start']['Value']) ? $prefs['partial-access-start']['Value'] : '')?>">
												<input type="hidden" name="tickets[partial-access-end][<?=$ticket['ID']?>]" id="end-time-value-<?=$ticket['ID']?>" value="<?=(isset($prefs['partial-access-end']['Value']) ? $prefs['partial-access-end']['Value'] : '')?>">
												<span class="time-indication" id="from-time-<?=$ticket['ID']?>"></span>
												<span class="time-indication" id="end-time-<?=$ticket['ID']?>"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<span>Designated seating<a href="#popup-help" class="popup-help" data-type="help" data-id="38"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
												<input type="checkbox" class="designated-seating-check" value="1" name="tickets[designated-seating-access][<?=$ticket['ID']?>]" <?=(isset($prefs['designated-seating-access']['Value']) && $prefs['designated-seating-access']['Value'] == '1' ? 'checked' : '')?>/>
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<span>Row indicators</span>
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<input type="radio" name="tickets[row-indicator][<?=$ticket['ID']?>]" id="designated-seating-option-<?=$ticket['ID']?>-1" value="1" <?=( isset($prefs['row-indicator']['Value']) && $prefs['row-indicator']['Value'] =='1' ? 'checked' : '' )?>>
												<label for="designated-seating-option-<?=$ticket['ID']?>-1">Numbers</label>
												<input type="radio" name="tickets[row-indicator][<?=$ticket['ID']?>]" id="designated-seating-option-<?=$ticket['ID']?>-2" value="2" <?=( isset($prefs['row-indicator']['Value']) && $prefs['row-indicator']['Value'] =='2' ? 'checked' : '' )?>>
												<label for="designated-seating-option-<?=$ticket['ID']?>-2">Characters</label>
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<span class="range">Range</span>
												<input type="text" class="range-input" name="tickets[row-range-start][<?=$ticket['ID']?>]" value="<?=( isset($prefs['row-range-start']['Value']) ? $prefs['row-range-start']['Value'] : '' )?>">
												<span class="range">&nbsp;-&nbsp;</span>
												<input type="text" class="range-input" name="tickets[row-range-end][<?=$ticket['ID']?>]" value="<?=( isset($prefs['row-range-end']['Value']) ? $prefs['row-range-end']['Value'] : '' )?>">
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<span>Chair numbers</span>
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<input type="radio" name="tickets[chair-indicator][<?=$ticket['ID']?>]" id="designated-chair-option-<?=$ticket['ID']?>-1" value="1" <?=( isset($prefs['chair-indicator']['Value']) && $prefs['chair-indicator']['Value'] =='1' ? 'checked' : '' )?>>
												<label for="designated-chair-option-<?=$ticket['ID']?>-1">Numbers</label>
												<input type="radio" name="tickets[chair-indicator][<?=$ticket['ID']?>]" id="designated-chair-option-<?=$ticket['ID']?>-2" value="2" <?=( isset($prefs['chair-indicator']['Value']) && $prefs['chair-indicator']['Value'] =='2' ? 'checked' : '' )?>>
												<label for="designated-chair-option-<?=$ticket['ID']?>-2">Characters</label>
											</div>
										</div>
										<div class="row designated-seating-option">
											<div class="col-md-12">
												<span class="range">Range</span>
												<input type="text" class="range-input" name="tickets[chair-range-start][<?=$ticket['ID']?>]" value="<?=( isset($prefs['row-range-start']['Value']) ? $prefs['chair-range-start']['Value'] : '' )?>">
												<span class="range">&nbsp;-&nbsp;</span>
												<input type="text" class="range-input" name="tickets[chair-range-end][<?=$ticket['ID']?>]" value="<?=( isset($prefs['row-range-end']['Value']) ? $prefs['chair-range-end']['Value'] : '' )?>">
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 border-top">
												<span class="range">Ticketfee(per ticket)<a href="#popup-help" class="popup-help" data-type="help" data-id="39"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<span class="range">Non-shared
												</span>
												<input type="text" class="range-input price-input" name="tickets[fb-unshared-ticketfee][<?=$ticket['ID']?>]" value="<?=( isset($prefs['fb-unshared-ticketfee']['Value']) ? $prefs['fb-unshared-ticketfee']['Value'] : '' )?>">
												<span class="range">&nbsp;shared&nbsp;
												</span>
												<input type="text" class="range-input price-input" name="tickets[fb-shared-ticketfee][<?=$ticket['ID']?>]" value="<?=( isset($prefs['fb-shared-ticketfee']['Value']) ? $prefs['fb-shared-ticketfee']['Value'] : '' )?>">
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 border-top">
												<span class="range">Offer ensurance on tickets?<a href="#popup-help" class="popup-help" data-type="help" data-id="40"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<input type="radio" name="tickets[offer-ensurance][<?=$ticket['ID']?>]" id="offer-ensurance-option-<?=$ticket['ID']?>-1" value="1" <?=( isset($prefs['offer-ensurance']['Value']) && $prefs['offer-ensurance']['Value'] =='1' ? 'checked' : '' )?> class="ensurance-option">
												<label for="offer-ensurance-option-<?=$ticket['ID']?>-1">Yes</label>
												<input type="radio" name="tickets[offer-ensurance][<?=$ticket['ID']?>]" id="offer-ensurance-option-<?=$ticket['ID']?>-2" value="2" <?=( isset($prefs['offer-ensurance']['Value']) && $prefs['offer-ensurance']['Value'] =='2' ? 'checked' : '' )?> class="ensurance-option">
												<label for="offer-ensurance-option-<?=$ticket['ID']?>-2">No</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<? endif;
						endforeach; 
						/*
							Empty ticketbox
						 */
					else: $randID = rand();?>
						
					<div class="row ticket-wrapper odd">
						<div class="col-md-12">
							<div class="row general-inputs">
								<div class="col-md-3">
									<input type="text" name="tickets[tickets-name][0][]" placeholder="Ticketname">
								</div>
								<div class="col-md-3">
									<input type="text" name="tickets[tickets-capacity][0][]" placeholder="Capacity">
								</div>
								<div class="col-md-3 ppt-col">
									<div class="big-select">
										<select required class="big-select" id="eventtype" name="eventtype">
											<option value="EUR">&euro;</option>
											<option value="USD">$</option>
											<option value="CNY">&yen;</option>
											<option value="GBP">&pound;</option>
										</select>
									</div>
									<input type="text" value="" name="tickets[tickets-ppt][0][]" placeholder="Price(#,###.##)" class="price-input">
								</div>
								<div class="col-md-3">
									<div class="edit-button substract-row">
										<a href="#" class="edit-button substract-row" onclick="removeTicketRow(this, event);">
											<img src="<?=$base?>images/dashboard/icon/substract.png" />
										</a>
									</div>
									<div class="edit-button">
										<a href="#" class="expand-button">
											Expand
										</a>
									</div>
									<a href="#popup-help" class="popup-help" data-type="help" data-id="36"><img src="<?=$base?>images/questionmark.png" alt="question"></a>
								</div>
							</div>
							<div class="row ticket-options" style="display:block;">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12 border-top">
											<span>Partial access during event<a href="#popup-help" class="popup-help" data-type="help" data-id="37"><img src="<?=$base?>images/questionmark.png" alt="question"></a>
											</span>
											<input type="checkbox" class="partial-access-check" value="1" name="tickets[tickets-partial-access][0][]" checked />
										</div>
									</div>
									<div class="row partial-access-option">
										<div class="col-md-6">
											<div class="slider-range" id="slider-id-<?=$randID?>" data-id="<?=$randID?>" 
												data-cur-min="<?=date('U', strtotime(str_replace('/', '-', $event['preferences']['start_date']['Value'].' '.$event['preferences']['start_time']['Value'])))?>" 
												data-cur-max="<?=date('U', strtotime(str_replace('/', '-', $event['preferences']['end_date']['Value'].' '.$event['preferences']['end_time']['Value'])))?>">
											</div>
										</div>
										<div class="col-md-6">
											<input type="hidden" name="tickets[partial-access-start][0][]" id="from-time-value-<?=$randID?>" value="">
											<input type="hidden" name="tickets[partial-access-end][0][]" id="end-time-value-<?=$randID?>" value="">
											<span class="time-indication" id="from-time-<?=$randID?>">
											</span>
											<span class="time-indication" id="end-time-<?=$randID?>">
											</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 border-top">
											<span>Designated seating<a href="#popup-help" class="popup-help" data-type="help" data-id="38"><img src="<?=$base?>images/questionmark.png" alt="question"></a>
											</span>
											<input type="checkbox" class="designated-seating-check" value="1" name="tickets[designated-seating-access][0][]" checked />
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<span>Row indicators
											</span>
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<input type="radio" name="tickets[row-indicator][0][]" id="row-indicator-option-<?=$randID?>-1" value="1">
											<label for="row-indicator-option-<?=$randID?>-1">Numbers
											</label>
											<input type="radio" name="tickets[row-indicator][0][]" id="row-indicator-option-<?=$randID?>-2" value="2">
											<label for="row-indicator-option-<?=$randID?>-2">Characters
											</label>
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<span class="range">Range
											</span>
											<input type="text" class="range-input" name="tickets[row-range-start][0][]">
											<span class="range">&nbsp;-&nbsp;
											</span>
											<input type="text" class="range-input" name="tickets[row-range-end][0][]">
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<span>Chair number</span>
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<input type="radio" name="tickets[chair-indicator][0][]" id="designated-seating-option-<?=$randID?>-1" value="1">
											<label for="designated-seating-option-<?=$randID?>-1">Numbers
											</label>
											<input type="radio" name="tickets[chair-indicator][0][]" id="designated-seating-option-<?=$randID?>-2" value="2">
											<label for="designated-seating-option-<?=$randID?>-2">Characters
											</label>
										</div>
									</div>
									<div class="row designated-seating-option">
										<div class="col-md-12">
											<span class="range">Range
											</span>
											<input type="text" class="range-input" name="tickets[chair-range-start][0][]">
											<span class="range">&nbsp;-&nbsp;
											</span>
											<input type="text" class="range-input" name="tickets[chair-range-end][0][]">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 border-top">
											<span class="range">Ticketfee(per ticket)<a href="#popup-help" class="popup-help" data-type="help" data-id="39"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<span class="range">Non-shared
											</span>
											<input type="text" class="range-input price-input" name="tickets[fb-unshared-ticketfee][0][]">
											<span class="range">&nbsp;shared&nbsp;
											</span>
											<input type="text" class="range-input price-input" name="tickets[fb-shared-ticketfee][0][]">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 border-top">
											<span class="range">Offer ensurance on tickets?<a href="#popup-help" class="popup-help" data-type="help" data-id="40"><img src="<?=$base?>images/questionmark.png" alt="question"></a></span>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<input type="radio" name="tickets[offer-ensurance][0][]" id="offer-ensurance-option-<?=$randID?>-1" value="1" class="ensurance-option">
											<label for="offer-ensurance-option-<?=$randID?>-1">Yes</label>
											<input type="radio" name="tickets[offer-ensurance][0][]" id="offer-ensurance-option-<?=$randID?>-2" value="2" class="ensurance-option">
											<label for="offer-ensurance-option-<?=$randID?>-2">No</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
							$(".designated-seating-option, .partial-access-option").css("display", "block");
						</script>
					</div>
				<?endif;?>
			</div>
		</div>

	</div>

	<div class="row add-ticket-wrapper">
		<div class="col-md-12">
			<a href="#" id="add-ticket" class="edit-button">
				<img src="<?=$base?>images/dashboard/icon/add.png" />
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 error-field" style="display: none;">
			<p class="error">Not every field has been filled in correctly.</p>
			<ul class="error-list">
			</ul>
		</div>
		<div class="col-md-12">
			<input type="submit" name="tickets-submit" value="Next step" />
		</div>
	</div>
</form>
<script>
	function slideTime(event, ui){
		if( typeof $(this).attr('data-id') == 'undefined'){
			var id = $(this).attr('data-id');
			var val0 = $(this).slider("values", 0), val1 = $(this).slider("values", 1),
			hours0 = parseInt(val0 / 60 % 24, 10), hours1 = parseInt(val1 / 60 % 24, 10);
		}
		else{
			var id = $(this).attr('data-id');
			var val0 = $(this).slider("values", 0), val1 = $(this).slider("values", 1),
			hours0 = parseInt(val0 / 60 % 24, 10), hours1 = parseInt(val1 / 60 % 24, 10);
		}
		x = new Date(val0*1000);
		y = new Date(val1*1000);
		$("#from-time-"+id).html( '<span class="time">' + ('0'+x.getHours()).slice(-2) + ':' + ('0'+x.getMinutes()).slice(-2) + '</span><span class="date">' + x.getDate()+'/'+(x.getMonth()+1)+'/'+x.getFullYear() +'</span>' );
		$("#end-time-"+id).html( '<span class="time">' + ('0'+y.getHours()).slice(-2) + ':' + ('0'+y.getMinutes()).slice(-2) + '</span><span class="date">' + y.getDate()+'/'+(y.getMonth()+1)+'/'+y.getFullYear() +'</span>' );

		$("#from-time-value-"+id).val( x.getTime()/1000 );
		$("#end-time-value-"+id).val( y.getTime()/1000 );
	}
	var eventStart = <?=date('U', strtotime(str_replace('/', '-', $event['preferences']['start_date']['Value'].' '.$event['preferences']['start_time']['Value'])))?>,
	eventEnd = <?=date('U', strtotime(str_replace('/', '-', $event['preferences']['end_date']['Value'].' '.$event['preferences']['end_time']['Value'])))?>;
</script>