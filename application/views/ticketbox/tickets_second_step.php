<div class="row event-background-color-background">
	<div class="col-md-12">
		<form method="post" action="" id="registerform" novalidate="novalidate">
			<input type="hidden" value="signup" name="type" />
			<div class="sign-up-wrapper">
				<div class="pattern"><h2 class="event-background-color-background text-color-text">User data</h2></div>
				<p class="text-color-text">To give you the proper service you need, we need some personal data.</p>
				<div class="clear"></div>
				<form action="" method="post" id="buyer-data-form" novalidate="novalidate">
					<input type="hidden" name="orderid" value="<?=$order_id?>" />
					<? if(!isset($user['UserName']) || $user['UserName'] ==''): ?>
						<div class="row">
							<div class="col-md-6">
								<input type="text" name="user[preferences][email]" required class="email" placeholder="User emailadres"/>
							</div>
						</div>
					<?endif;?>
					<div class="clear"></div>
					<p class="text-color-text">We need some data for all the ticketreceivers.</p>
						<? 	$j = 1; 
							$checkedFlag = false; 
							foreach ($tickets as $key => $value):
								if(isset($value['buyerpreferences'][1]['Value']) && $value['buyerpreferences'][1]['Value'] == '1' || !isset($wrwecvwe)):
									?>
									<h4 class="text-color-text">Ticket <?=$value['preferences']['tickets-name']['Value']?></h4>
								<?	for ($i=0; $i < $value['Quantity']; $i++): ?>
									<div class="row" style="border:none;">
										<div class="col-md-3">
											<input type="text" name="ticketdata[<?=$value['ID']?>][<?=$i?>][naam]" placeholder="Name ticketholder <?=$j?>" required class="subtext-color-text"/>
										</div>
										<div class="col-md-6">
											<input type="text" name="ticketdata[<?=$value['ID']?>][<?=$i?>][e-mail]" placeholder="Emailadress ticketholder <?=$j?>" required class="email subtext-color-text"/>
										</div>
										<div class="col-md-3 gender-buttons">
											<input type="radio" name="ticketdata[<?=$value['ID']?>][<?=$i?>][gender]" id="ticketdata-<?=$value['ID']?>-<?=$i?>-man" value="man" required>
											<label for="ticketdata-<?=$value['ID']?>-<?=$i?>-man" class="text-color-text">Man</label>
											<input type="radio" name="ticketdata[<?=$value['ID']?>][<?=$i?>][gender]" id="ticketdata-<?=$value['ID']?>-<?=$i?>-woman" value="woman" required>
											<label for="ticketdata-<?=$value['ID']?>-<?=$i?>-woman" class="text-color-text">Woman</label>
										</div>
									</div>
								<? $j++; endfor; ?>
							<? endif; ?>
						<? endforeach; ?>
				</form>
			</div>
		</form>
	</div>
	<div class="row event-background-color-background">
		<div class="col-md-3">
			<div class="float-left">
				<div class="clear"></div>
				<div class="float-left"><a href="#" class="blue-btn cancel-order primary-color-background" style="margin-left: 25px;">Go back</a></div>
			</div>
		</div>
		<div class="col-md-6 lower-btns">
			<div class="float-right">
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-md-3 lower-btns">
			<div class="float-right">
				<div class="clear"></div>
				<span id="valide"></span>
				<div class="float-left"><a href="#" class="blue-btn next-step-data-buyers primary-color-background" current-step="2">Next</a></div>
			</div>
		</div>
	</div>
<!--<div class="preview-row event-background-color-background">
				<div class="steps">
					<div class="step">
						<span class="step-number steps-color-background text-color-text">1</span><span class="step-title">Tickets</span>
					</div>
					<div class="step active">
						<span class="step-number primary-color-background text-color-text">2</span><span class="step-title">Personal info</span>
					</div>
					<div class="step">
						<span class="step-number -color-background text-color-text">3</span><span class="step-title">Confirmation</span>
					</div>
					<div class="step">
						<span class="step-number steps-color-background text-color-text">4</span><span class="step-title">Payment</span>
					</div>
				</div>
			</div>
			<div class="preview-row event-background-color-background">
				<div class="left">
					<p class="introduction text-color-text"> <br />
						Your order is being handled by Tibbaa.</p>
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
			</div>
			<div class="preview-row event-background-color-background">
				<form class="step-tickets" method="post" action="">
					<table>
						<tr>
							<th class="text-color-text">Title</th>
							<td>
								<input type="radio" name="sex" class="" required value="male" <?=(isset($preused_preferences['preferences']['sex']['Value']) && $preused_preferences['preferences']['sex']['Value'] == 'male' ? 'checked' : '')?> />Mr. 
								<input type="radio" name="sex" required value="female" <?=(isset($preused_preferences['preferences']['sex']['Value']) && $preused_preferences['preferences']['sex']['Value'] == 'female' ? 'checked' : '')?> />Ms.
							</td>
						</tr>
						<tr>
							<th class="text-color-text">Name</th>
							<td>
								<input type="text" name="firstname" required class="" placeholder="First name" value="<?=(isset($preused_preferences['preferences']['firstname']['Value']) && $preused_preferences['preferences']['firstname']['Value'] != '' ? $preused_preferences['preferences']['firstname']['Value'] : '')?>" />
								<input type="text" name="lastname" placeholder="Last name" value="<?=(isset($preused_preferences['preferences']['lastname']['Value']) && $preused_preferences['preferences']['lastname']['Value'] != '' ? $preused_preferences['preferences']['lastname']['Value']: '')?>" />
							</td>
						</tr>
						<tr>
							<th class="text-color-text">E-mail</th>
							<td>
								<input type="text" name="email" required class="email" placeholder="Email address" value="<?=(isset($preused_preferences['preferences']['email']['Value']) && $preused_preferences['preferences']['email']['Value'] != '' ? $preused_preferences['preferences']['email']['Value'] : '')?>" />
							</td>
						</tr>
						<tr>
							<th class="text-color-text">Address</th>
							<td>
								<input type="text" name="address"  class="" placeholder="Address" value="<?=(isset($preused_preferences['preferences']['address']['Value']) && $preused_preferences['preferences']['address']['Value'] != '' ? $preused_preferences['preferences']['address']['Value'] : '')?>" />
								<input type="text" name="househumber" placeholder="House number" value="<?=(isset($preused_preferences['preferences']['househumber']['Value']) && $preused_preferences['preferences']['househumber']['Value'] != '' ? $preused_preferences['preferences']['househumber']['Value'] : '')?>" />
							</td>
						</tr>
						<tr>
							<th class="text-color-text"></th>
							<td><input type="text" name="postalcode" class="" placeholder="Postal Code" value="<?=(isset($preused_preferences['preferences']['postalcode']['Value']) && $preused_preferences['preferences']['postalcode']['Value'] != '' ? $preused_preferences['preferences']['postalcode']['Value'] : '')?>" /><input type="text" name="city" placeholder="City" value="<?=(isset($preused_preferences['preferences']['city']['Value']) && $preused_preferences['preferences']['city']['Value'] != '' ? $preused_preferences['preferences']['city']['Value'] : '')?>" /></td>
						</tr>
						<tr>
							<th class="text-color-text">Country</th>
							<td>
								<select>
									<option>Netherlands</option>
									<option>France</option>
									<option>England</option>
									<option>China</option>
									<option>Japan</option>
								</select>
							</td>
						</tr>
						<tr>
							<th class="text-color-text">Phonenumber</th>
							<td><input type="text" name="phonenumber" placeholder="Phonenumber" <?=(isset($preused_preferences['preferences']['phonenumber']['Value']) && $preused_preferences['preferences']['phonenumber']['Value'] != '' ? $preused_preferences['preferences']['phonenumber']['Value'] : '')?> /></td>
						</tr>
						<tr>
							<th class="text-color-text">Newsletter</th>
							<td><input type="checkbox" name="newsletter" /><span class="text-color-text">Yes, I want to sign up for the newsletter.</span></td>
						</tr>
					</table>
				</form>
				<div class="preview-row event-background-color-background">
					<span id="valide"></span>
					<a class="next-step primary-color-background" current-step="2">Next</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!--<h1>Tickets bestellen</h1>
<div class="row" id="steps">
	<div class="col-sm-3">
		<h2>1. Tickets</h2>
	</div>
	<div class="col-sm-3">
		<h2 class="active">2. Gegevens</h2>
	</div>
	<div class="col-sm-3">
		<h2>3. Overzicht</h2>
	</div>
	<div class="col-sm-3">
		<h2>4. Afrekenen</h2>
	</div>
</div>
<div id="step2" class="steps">
	<form class="step-tickets">
		<table method="post" action="">
			<tr>
				<th>Title</th>
				<td>
					<input type="radio" name="sex" class="" required value="male" <?=(isset($preused_preferences['preferences']['sex']['Value']) && $preused_preferences['preferences']['sex']['Value'] == 'male' ? 'checked' : '')?> />Mr. 
					<input type="radio" name="sex" required value="female" <?=(isset($preused_preferences['preferences']['sex']['Value']) && $preused_preferences['preferences']['sex']['Value'] == 'female' ? 'checked' : '')?> />Ms.
				</td>
			</tr>
			<tr>
				<th>Name</th>
				<td>
					<input type="text" name="firstname" required class="" placeholder="First name" value="<?=(isset($preused_preferences['preferences']['firstname']['Value']) && $preused_preferences['preferences']['firstname']['Value'] != '' ? $preused_preferences['preferences']['firstname']['Value'] : '')?>" />
					<input type="text" name="lastname" placeholder="Last name" value="<?=(isset($preused_preferences['preferences']['lastname']['Value']) && $preused_preferences['preferences']['lastname']['Value'] != '' ? $preused_preferences['preferences']['lastname']['Value']: '')?>" />
				</td>
			</tr>
			<tr>
				<th>E-mail</th>
				<td>
					<input type="text" name="email" required class="email" placeholder="Email address" value="<?=(isset($preused_preferences['preferences']['email']['Value']) && $preused_preferences['preferences']['email']['Value'] != '' ? $preused_preferences['preferences']['email']['Value'] : '')?>" />
				</td>
			</tr>
			<tr>
				<th>Address</th>
				<td>
					<input type="text" name="address"  class="" placeholder="Address" value="<?=(isset($preused_preferences['preferences']['address']['Value']) && $preused_preferences['preferences']['address']['Value'] != '' ? $preused_preferences['preferences']['address']['Value'] : '')?>" />
					<input type="text" name="househumber" placeholder="House number" value="<?=(isset($preused_preferences['preferences']['househumber']['Value']) && $preused_preferences['preferences']['househumber']['Value'] != '' ? $preused_preferences['preferences']['househumber']['Value'] : '')?>" />
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="text" name="postalcode" class="" placeholder="Postal Code" value="<?=(isset($preused_preferences['preferences']['postalcode']['Value']) && $preused_preferences['preferences']['postalcode']['Value'] != '' ? $preused_preferences['preferences']['postalcode']['Value'] : '')?>" /><input type="text" name="city" placeholder="City" value="<?=(isset($preused_preferences['preferences']['city']['Value']) && $preused_preferences['preferences']['city']['Value'] != '' ? $preused_preferences['preferences']['city']['Value'] : '')?>" /></td>
			</tr>
			<tr>
				<th>Country</th>
				<td>
					<select>
						<option>Netherlands</option>
						<option>France</option>
						<option>England</option>
						<option>China</option>
						<option>Japan</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Phonenumber</th>
				<td><input type="text" name="phonenumber" placeholder="Phonenumber" <?=(isset($preused_preferences['preferences']['phonenumber']['Value']) && $preused_preferences['preferences']['phonenumber']['Value'] != '' ? $preused_preferences['preferences']['phonenumber']['Value'] : '')?> /></td>
			</tr>
			<tr>
				<th>Newsletter</th>
				<td><input type="checkbox" name="newsletter" />Yes, I want to sign up for the newsletter.</td>
			</tr>
		</table>
	</form>
	<hr />
	<div class="floatleft">
		<!--<a class="prevstep">Back</a>--
	</div>
	<div class="floatright">
		<a class="next-step" current-step="2">Next</a>
	</div>
</div>-->
<?=$scripts?>