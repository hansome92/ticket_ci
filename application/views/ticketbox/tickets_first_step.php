				<div class="row event-background-color-background">
					<form method="post" action="">
						<div class="col-md-12">
							<div class="overzichts-table">
								<? if(isset($event['preferences']['end_date']['Value'])){
										$enddate = str_replace('/', '-', $event['preferences']['end_date']['Value']).(isset($event['preferences']['end_time']['Value']) && $event['preferences']['end_time']['Value'] != '' ? ' '.$event['preferences']['end_time']['Value'] : '');
									}
									if( isset($enddate) && $enddate < time() ||
										strtotime(str_replace('/', '-', $event['preferences']['start_date']['Value']).(isset($event['preferences']['start_time']['Value']) && $event['preferences']['start_time']['Value'] != '' ? ' '.$event['preferences']['start_time']['Value'] : '')) > time() && $event['Status'] != '2'
										): ?>
									<table id="ticketinfo">
										<thead>
											<tr>
												<th class="primary-color-background primary-text-color-text">Ticket</th>
												<th class="primary-color-background primary-text-color-text">Price</th>
												<th class="primary-color-background primary-text-color-text">Amount</th>
												<th class="primary-color-background primary-text-color-text">Total</th>
											</tr>
										</thead>
										<tbody>
											<? foreach($event['tickets'] as $key => $value): if(isset($value['preferences'])):?>
											<tr class="js-ticket-row">
												<td class="text-color-text ticketbox-color-background"><?=$value['preferences']['tickets-name']['Value'];?></td>
												<?if($value['available'] == true):?>
													<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-default"><?=_getFormattedNumber($value['preferences']['tickets-ppt']['Value'])?></span></td>
													<td class="first-step-amount text-color-text ticketbox-color-background">

														<a href="#" class="minus" data-id="<?=$value['ID'];?>">&#10134;</a>
														<span class="js-price text-color-text" id="target-textbox-span-<?=$value['ID'];?>">0</span>
														<input type="text" class="js-price-input" id="target-textbox-<?=$value['ID'];?>" value="0" name="tickets[<?=$value['ID'];?>]">
														<a href="#" class="plus" data-id="<?=$value['ID'];?>">&#10133;</a>
													</td>
													<td class="text-color-text ticketbox-color-background">&euro; <span class="js-price-result">0,00</span></td>
												<? else: ?>
													<td colspan="2" class="text-color-text ticketbox-color-background"></td>
													<td class="text-color-text ticketbox-color-background">Soldout</td>
												<?endif; ?>
											</tr>
											<? endif; endforeach; ?>
										</tbody>
										<tfoot>
											<? foreach ($event['tickets'] as $key => $value) {if(isset($value['preferences']['offer-ensurance']['Value']) && $value['preferences']['offer-ensurance']['Value'] == '1'){$ensuranceFlag = true;}} ?>
											<? if(isset($ensuranceFlag) && $ensuranceFlag === true): ?>
												<tr>
													<td class="text-color-text" colspan="3"><span class="">Cancellation ensurance for <span class="ensurance-value" style="display:inline; float:none;">&euro; 0,00</span> on your tickets.</span></td>
													<td class="text-color-text">
														<input type="radio" name="cancel-ensurance" id="ensurance-yes" class="ensurance-input" value="yes">
														<label class="text-color-text" for="ensurance-yes" >Yes</label>
														<input type="radio" name="cancel-ensurance" id="ensurance-no" class="ensurance-input" value="no">
														<label class="text-color-text" for="ensurance-no">No</label>
													</td>
												</tr>
											<? endif; ?>
											<tr>
												<td class="text-color-text" colspan="3"><span>Subtotal</span></td>
												<td class="text-color-text">&euro; <span class="js-price-total" style="float:none; width: auto; display: inline;">0,00</span></td>
											</tr>
										</tfoot>
									</table>
								<? elseif(isset($event['Status']) && $event['Status'] == '2'):?>
									<p class="text-color-text">Event is no longer active.</p>
								<? else: ?>
									<p class="text-color-text">This event has passed.</p>
								<? endif; ?>
							</div>
						</form>		
					</div>	
					<div class="row event-background-color-background">
						<div class="col-md-12 lower-btns">
							<div class="float-right">
								<div class="clear"></div>
								<span id="valide"></span>
								<div class="float-left"><a href="#" class="blue-btn next-step primary-color-background" current-step="1">Next</a></div>
							</div>
						</div>
					</div>
				</div>
<?=$scripts?>