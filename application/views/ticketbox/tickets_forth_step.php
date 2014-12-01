<--<h2>Tickets</h2>
	<div class="steps">
		<div class="done">
			<span>Tickets</span>
		</div>
		<div class="done">
			<span>Info</span>
		</div>
		<div>
			<span>Checkout</span>
		</div>
	</div>
	<div class="res-tickets">
		<table>
			<thead>
				<tr>
					<th>Type</th>
					<th>Price</th>
					<th>Amount</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td>Total</td>
					<td>&euro;<?=$total?></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="tickets">
		<form method="GET" action="https://test.adyen.com/hpp/pay.shtml" target="_blank" class="paymentform">
			<input type="hidden" name="merchantReference" value="<?=$paymentform['merchantReference'] ?>"/>
			<input type="hidden" name="paymentAmount" value="<?=$paymentform['paymentAmount'] ?>"/>
			<input type="hidden" name="currencyCode" value="<?=$paymentform['currencyCode'] ?>"/>
			<input type="hidden" name="shipBeforeDate" value="<?=$paymentform['shipBeforeDate'] ?>"/>
			<input type="hidden" name="skinCode" value="<?=$paymentform['skinCode'] ?>"/>
			<input type="hidden" name="merchantAccount" value="<?=$paymentform['merchantAccount'] ?>"/>
			<input type="hidden" name="sessionValidity" value="<?=$paymentform['sessionValidity'] ?>"/>
			<input type="hidden" name="shopperLocale" value="<?=$paymentform['shopperLocale'] ?>"/>
			<input type="hidden" name="orderData" value="<?=$paymentform['orderData'] ?>"/>
			<input type="hidden" name="countryCode" value="<?=$paymentform['countryCode'] ?>"/>
			<input type="hidden" name="shopperEmail" value="<?=$paymentform['shopperEmail'] ?>"/>
			<input type="hidden" name="shopperReference" value="<?=$paymentform['shopperReference'] ?>"/>
			<input type="hidden" name="allowedMethods" value="<?=$paymentform['allowedMethods'] ?>"/>
			<input type="hidden" name="blockedMethods" value="<?=$paymentform['blockedMethods'] ?>"/>
			<input type="hidden" name="offset" value="<?=$paymentform['offset'] ?>"/>
			<input type="hidden" name="merchantSig" value="<?=$paymentform['merchantSig'] ?>"/>	
			<input type="submit" value="Create payment" />
		</form>
	</div>
	<div>
		<a href="#"></a>
		<a href="#" onclick="$('.paymentform').submit();" class="next-step" current-step="">Payment</a>
	</div>-->

	<!--STEP 4 -->
			<h1>Tickets bestellen</h1>
			<div class="row" id="steps">
				<div class="col-sm-3">
					<h2>1. Tickets</h2>
				</div>
				<div class="col-sm-3">
					<h2>2. Gegevens</h2>
				</div>
				<div class="col-sm-3">
					<h2>3. Overzicht</h2>
				</div>
				<div class="col-sm-3">
					<h2 class="active">4. Afrekenen</h2>
				</div>
			</div>
			<div id="step4" class="steps">
				Step 4
				<table id="eventinfo">
					<tr>
						<th>Event</th>
						<td>This is the name of the event</td>
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
				<table id="ticketinfo">
					<tr>
						<th class="tickets">Ticket</th>
						<th class="price">Price</th>
						<th class="amount">Amount</th>
						<th class="total">Total</th>
					</tr>
					<tr>
						<td>Normal</td>
						<td>&euro; 59,00</td>
						<td><select><option>1</option><option>2</option><option>3</option><option>4</option></select></td>
						<td>&euro; 59,00</td>
					</tr>
				</table>
				<hr />
				<div class="floatleft">
					<input class="prevstep" type="submit" name="submit" value="Back" />
				</div>
				<div class="floatright">
					<input class="placeorder" type="submit" name="submit" value="Place order" />
				</div>
			</div>
			<?=$scripts?>