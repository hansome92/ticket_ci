<div class="row event-background-color-background">
	<div class="visible-md visible-lg col-md-12 visible-xs visible-sm col-md-12">
		<div class="overzichts-table">
			<table>
				<thead>
					<tr>
						<th class="primary-color-background primary-text-color-text">Ticket</th>
						<th class="primary-color-background primary-text-color-text">Price</th>
						<th class="primary-color-background primary-text-color-text">Amount</th>
						<th class="primary-color-background primary-text-color-text">Total</th>
					</tr>
				</thead>
				<tbody>
					<? $totalEnsurance = 0; // Define total ensurance for later use
						foreach($tickets as $key => $value):?>
						<? $totalEnsurance += ($value['preferences']['tickets-ppt']['Value']*$value['Quantity']/10);?>
						<tr id="data-row-<?=$value['ID']?>">
							<td class="text-color-text ticketbox-color-background"><?=(isset($value['preferences']['tickets-ppt']) ? $value['preferences']['tickets-name']['Value'] : '' )?></td>
							<td class="text-color-text ticketbox-color-background">&euro; <?=_getFormattedNumber($value['preferences']['tickets-ppt']['Value']);?></td>
							<td class="text-color-text ticketbox-color-background"><?=$value['Quantity'];?></td>
							<td class="text-color-text ticketbox-color-background">&euro; <?=_getFormattedNumber((is_numeric($value['preferences']['tickets-ppt']['Value']) ? $value['preferences']['tickets-ppt']['Value'] : str_replace(',', '.', $value['preferences']['tickets-ppt']['Value']) )*$value['Quantity'] );?></td>
							<!--<td><a href="#" class="delete-ticket" data-id="<?=$value['ID']?>" data-name="<?=$value['preferences']['tickets-name']['Value']?>">X</a></td>-->
						</tr>
					<?endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row event-background-color-background">
		<div class="col-md-7 col-sm-12">
			<div class="social-media-share-wrapper">
				<div class="pattern"><h2 class="event-background-color-background text-color-text">Share on social media</h2></div>
				<div class="clear"></div>
				<p class="text-color-text">Share this event on your social media and get a discount on your <a href="#" class="text-color-text">administration fee</a></p>
				<div class="row">
					<div class="col-md-12">
						<a id="fb-share-button" class="social-media-btn primary-color-background primary-text-color-text" onclick="checkFBTrue();" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=htmlspecialchars_decode($facebook_metalink);?>&t=<?=$facebook_text?>">
							<img src="<?=$base?>images/ticketbox/facebook.png" alt="" class="social-media-icon">
							<span>Facebook</span>
						</a>
					</div>
					<!--<div class="col-md-4">
						<a href="#" class="social-media-btn">
							<img src="<?=$base?>images/ticketbox/twitter.png" alt="" class="social-media-icon">
							<span>Twitter</span>
						</a>
					</div>
					<div class="col-md-4">
						<a href="#" class="social-media-btn">
							<img src="<?=$base?>images/ticketbox/linkedin.png" alt="" class="social-media-icon">
							<span>Linkedin</span>
						</a>
					</div>-->
				</div>
			</div>
		</div>
		<div class="col-md-5 col-sm-12">
			<div class="totals-wrapper ticketbox-color-background">
				<table>
					<tbody>
						<? $totalShared = 0; $totalUnshared = 0; 
							foreach ($order['eticketbuyer'] as $key => $value) {
								if(isset($order['preferences']['shared_on_facebook']['Value']) && $order['preferences']['shared_on_facebook']['Value'] == '1'){
									$totalShared += $value['preferences']['fb-shared-ticketfee']['Value']*$value['Quantity'];
								} 
								else{
									$totalUnshared += $value['preferences']['fb-unshared-ticketfee']['Value']*$value['Quantity'];
								}
							}
							echo $totalUnshared . '+' .$totalShared;
						?>
						<tr>
							<td>Administration fee:</td>
							<?if(isset($order['preferences']['shared_on_facebook']['Value'])):?>
								<td>&euro; <span id="shared-field"><?=_getFormattedNumber($totalShared);?></span></td>
							<?else:?>
								<td>&euro; <span id="shared-field"><?=_getFormattedNumber($totalUnshared);?></span></td>
							<?endif;?>
						</tr>
						
						<? if($order['preferences']['cancel-ensurance']['Value'] != 'no' && $ensurance != 0): ?>
							<tr>
								<td>Ensurance:</td>
								<td>&euro; <span id=""><?=_getFormattedNumber($ensurance)?></span></td>
							</tr>
						<? endif; ?>
						<tr>
							<td>Transaction fee:</td>
							<td>&euro; <span id=""><?=_getFormattedNumber($transactionfee)?></span></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td>Total:</td>
							<td>&euro; <span id="total-visible-price"><?=_getFormattedNumber(($paymentform['paymentAmount']/100));?></span></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row event-background-color-background">
		<div class="col-md-3">
			<div class="float-left">
				<div class="clear"></div>
				<div class="float-left"><a href="#" class="blue-btn cancel-order primary-color-background" style="margin-left: 25px;">Go back</a></div>
			</div>
		</div>
		<div class="col-md-5 lower-btns">
			<div class="float-right">
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-md-4 lower-btns">
			<div class="float-right">
				<div class="clear"></div>
				<div class="float-left">
					<input type="hidden" id="merchantReference" name="merchantReference" value="<?=$order_id?>"/>
					<a class="payment-submit primary-color-background primary-text-color-text blue-btn" href="<?=$paymentform['payment_url'] ?>">Create payment</a>
				</div>
			</div>
		</div>		
			<!--<div class="preview-row event-background-color-background">
				<div class="steps">
					<div class="step">
						<span class="step-number steps-color-background text-color-text">1</span><span class="step-title">Tickets</span>
					</div>
					<div class="step">
						<span class="step-number steps-color-background text-color-text">2</span><span class="step-title">Personal info</span>
					</div>
					<div class="step active">
						<span class="step-number primary-color-background text-color-text">3</span><span class="step-title">Confirmation</span>
					</div>
					<div class="step">
						<span class="step-number steps-color-background text-color-text">4</span><span class="step-title">Payment</span>
					</div>
				</div>
			</div>
			<div class="preview-row event-background-color-background">
				<div class="left">
					<p class="introduction text-color-text"> <br /></p>
					<table class="event-info">
						<tr>
							<td class="text-color-text">Event:</td>
							<td class="event-info-node event-title primary-color-text"><?=$event['EventName']?></td>
							<td class="text-color-text">Date:</td>
							<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['start_date']['Value']) ? $event['preferences']['start_date']['Value'] : $event['preferences']['starte_date']['Value'] )?></td>
						</tr>
						<tr>
							<td class="text-color-text">Venue:</td>
							<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['venue']['Value']) && $event['preferences']['venue']['Value'] != '' ? $event['preferences']['venue']['Value'].', ' : '').$event['preferences']['city']['Value']?></td>
							<td class="text-color-text">Event time:</td>
							<td class="event-info-node subtext-color-text"><?=(isset($event['preferences']['start_time']['Value']) && $event['preferences']['start_time']['Value'] != '' ? $event['preferences']['start_time']['Value'] : '')?> - <?=(isset($event['preferences']['end_time']['Value']) && $event['preferences']['end_time']['Value'] != '' ? $event['preferences']['end_time']['Value'] : '')?></td>
						</tr>
					</table>
				</div>
				<!--<div class="right">
					<img src="<?=$base?>images/dashboard/dashboard-preview/180x180.gif" alt="" class="seatmap">
				</div>--
				<table id="ticketinfo">
					<thead>
						<tr>
							<th class="tickets primary-color-background">Ticket</th>
							<th class="price primary-color-background">Price</th>
							<th class="amount primary-color-background">Amount</th>
							<th class="total primary-color-background">Total</th>
							<th class="primary-color-background"></th>
						</tr>
					</thead>
					<tbody>
						<?foreach($tickets as $key => $value):?>
							<tr id="data-row-<?=$value['ID']?>">
								<td><?=(isset($value['preferences']['tickets-ppt']) ? $value['preferences']['tickets-name']['Value'] : '' )?></td>
								<td>&euro; <?=$value['preferences']['tickets-ppt']['Value'];?></td>
								<td><?=$value['Quantity'];?></td>
								<td>&euro; <?=_getFormattedNumber((is_numeric($value['preferences']['tickets-ppt']['Value']) ? $value['preferences']['tickets-ppt']['Value'] : str_replace(',', '.', $value['preferences']['tickets-ppt']['Value']) )*$value['Quantity'] );?></td>
								<td><a href="#" class="delete-ticket" data-id="<?=$value['ID']?>" data-name="<?=$value['preferences']['tickets-name']['Value']?>">X</a></td>
							</tr>
						<?endforeach;?>
					</tbody>
					<tfoot>
						<tr class="facebook-row">
							<td colspan="2">
								<a id="fb-share-button" onclick="checkFBTrue();" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=htmlspecialchars_decode($facebook_metalink);?>&t=<?=$facebook_text?>">Share on Facebook</a>
								<div class="loading"></div>
							</td>
							<td>Administration fee</td>
							<td>&euro; <span id="admin-fee"><?=_getFormattedNumber(((isset($order['preferences']['shared_on_facebook']) && $order['preferences']['shared_on_facebook']['Value'] == 1 ? $administration_fee_after_shared : $administration_fee)/100));?></span></td>
							<td></td>
							<td></td>
						</tr>
						<? if($paymentform['ensurance'] > 0): ?>
							<tr class="ensurance-row">
								<td></td>
								<td></td> 
								<td>Ensurance</td>
								<td>&euro; <span id="total-visible-price"><?=_getFormattedNumber(($paymentform['ensurance']/100));?></span></td>
								<td></td>
								<td></td>
							</tr>
						<? endif; ?>
						<tr class="total-row">
							<td></td>
							<td></td>
							<td>Totaal</td>
							<td>&euro; <span id="total-visible-price"><?=_getFormattedNumber(($paymentform['paymentAmount']/100));?></span></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="preview-row event-background-color-background">
				<? /*<form method="GET" action="https://test.adyen.com/hpp/pay.shtml" target="" class="paymentform">
					<input type="hidden" id="merchantReference" name="merchantReference" value="<?=$paymentform['merchantReference'] ?>"/>
					<input type="hidden" id="paymentAmount" name="paymentAmount" value="<?=$paymentform['paymentAmount'] ?>"/>
					<input type="hidden" id="currencyCode" name="currencyCode" value="<?=$paymentform['currencyCode'] ?>"/>
					<input type="hidden" id="shipBeforeDate" name="shipBeforeDate" value="<?=$paymentform['shipBeforeDate'] ?>"/>
					<input type="hidden" id="skinCode" name="skinCode" value="<?=$paymentform['skinCode'] ?>"/>
					<input type="hidden" id="merchantAccount" name="merchantAccount" value="<?=$paymentform['merchantAccount'] ?>"/>
					<input type="hidden" id="sessionValidity" name="sessionValidity" value="<?=$paymentform['sessionValidity'] ?>"/>
					<input type="hidden" id="shopperLocale" name="shopperLocale" value="<?=$paymentform['shopperLocale'] ?>"/>
					<input type="hidden" id="orderData" name="orderData" value="<?=$paymentform['orderData'] ?>"/>
					<input type="hidden" id="countryCode" name="countryCode" value="<?=$paymentform['countryCode'] ?>"/>
					<input type="hidden" id="shopperEmail" name="shopperEmail" value="<?=$paymentform['shopperEmail'] ?>"/>
					<input type="hidden" id="shopperReference" name="shopperReference" value="<?=$paymentform['shopperReference'] ?>"/>
					<input type="hidden" id="allowedMethods" name="allowedMethods" value="<?=$paymentform['allowedMethods'] ?>"/>
					<input type="hidden" id="blockedMethods" name="blockedMethods" value="<?=$paymentform['blockedMethods'] ?>"/>
					<input type="hidden" id="offset" name="offset" value="<?=$paymentform['offset'] ?>"/>
					<input type="hidden" id="merchantSig" name="merchantSig" value="<?=$paymentform['merchantSig'] ?>"/>
					<input type="submit" class="payment-submit primary-color-background" value="Create payment" />
				</form>*/ ?>
				<a class="payment-submit primary-color-background" href="<?=$paymentform['payment_url'] ?>">Create payment</a>
			</div>
		</div>
	</div>
</div><!--STEP 3 --
			<h1>Tickets bestellen</h1>
			<div class="row" id="steps">
				<div class="col-sm-3">
					<h2>1. Tickets</h2>
				</div>
				<div class="col-sm-3">
					<h2>2. Gegevens</h2>
				</div>
				<div class="col-sm-3">
					<h2 class="active">3. Overzicht</h2>
				</div>
				<div class="col-sm-3">
					<h2>4. Afrekenen</h2>
				</div>
			</div>
			<div id="step3" class="steps">
				<table id="eventinfo">
					<tr>
						<th>Event</th>
						<td><?=$event['EventName'];?></td>
					</tr>
					<tr>
						<th>Venue</th>
						<td>Ziggo Dome, Amsterdam</td>
					</tr>
					<tr>
						<th>Date</th>
						<td>17 april 2014</td>
					</tr>
					<tr>
						<th>Event time</th>
						<td>22:00 - 05:00</td>
					</tr>
				</table>
				<hr />
				
				
				<hr />
				<div class="floatleft">
					<!--<input class="prevstep" type="submit" name="submit" value="Back" name="submit" value="Back" />--
				</div>
				<div class="floatright">
					<a class="payment-step" current-step="2" onclick="$('.paymentform').submit();">Pay</a>
				</div>
			</div>-->
			<?=$scripts?>