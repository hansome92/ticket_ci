<div class="row event-background-color-background" style="display: block;">
	<div class="col-md-6 col-xs-12">
		<div class="sign-in-wrapper">
			<form method="post" action="" id="loginform" novalidate="novalidate">
				<div class="pattern"><h2 class="event-background-color-background text-color-text">Sign In</h2></div>
				
				<div class="clear"></div>
				<p class="error" id="login-error"></p>
				<div class="input-icon"></div><input required type="text" name="username" id="username" class="username email" placeholder="Username"/>
				<div class="input-icon"></div><input required type="password" name="password" class="password" placeholder="Password"/>
				<div class="float-left"><a href="#" class="subtext-color-text">Forgot password?</a></div>
				<div class="float-right"><a href="#" id="loginform-submit" class="blue-btn primary-color-background primary-text-color-text">Sign in</a></div>
			</form>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="social-media-wrapper">
			<div class="pattern"><h2 class="event-background-color-background text-color-text">Use social media</h2></div>
			<div class="clear"></div>
			<a class="social-media-btn primary-color-background primary-text-color-text" <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.str_replace('%2F1', '', $fb_login_url['url']).'"' : 'data-id="'.$fb_login_url['id'].'"' )?>>
				<img src="<?=$base?>images/ticketbox/facebook.png" alt="" class="social-media-icon">
				<span class="primary-text-color-text">Facebook</span>
			</a>
			<!--<a href="#" class="social-media-btn primary-color-background primary-text-color-text">
				<img src="<?=$base?>images/ticketbox/twitter.png" alt="" class="social-media-icon">
				<span>Twitter</span>
			</a>
			<a href="#" class="social-media-btn primary-color-background primary-text-color-text">
				<img src="<?=$base?>images/ticketbox/linkedin.png" alt="" class="social-media-icon">
				<span>Linkedin</span>
			</a>-->
		</div>
	</div>
</div>
<div class="row event-background-color-background">
	<div class="col-md-12">
		<form method="post" action="" id="registerform" novalidate="novalidate">
			<input type="hidden" value="signup" name="type" />
			<div class="sign-up-wrapper">
				<div class="pattern"><h2 class="event-background-color-background text-color-text">Sign up</h2></div>
				<div class="clear"></div>
				<p><a href="#" id="sign-up" class="text-color-text">I don't have an account yet.</a></p>
				<div id="sign-up-form" style="display:none;">
					<div class="row">
						<div class="col-md-6">
							<input required type="text" name="preferences[firstname]" id="" class="" placeholder="First name">
						</div>
						<div class="col-md-6">
							<input required type="text" name="preferences[lastname]" id="" class="" placeholder="Last name">
						</div>
					</div>
					<div class="row">
						<div class="col-md-9">
							<input required type="text" name="preferences[address]" id="" class="" placeholder="Address">
						</div>
						<div class="col-md-3">
							<input required type="text" name="preferences[housenumber]" id="" class="" placeholder="Housenumber">
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<input required type="text" name="preferences[postalcode]" id="" class="" placeholder="Postalcode">
						</div>
						<div class="col-md-9">
							<input required type="text" name="preferences[city]" id="" class="" placeholder="City">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 big-select">
							<select required name="preferences[country]" id="land">
								<option value="0">Select a country</option>
								<option value="1">Netherlands</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="preferences[cellphone]" id="" class="" placeholder="Cellphone">
						</div>
					</div>
					<!--<div class="row">
						<div class="col-md-6">
							<input required type="text" name="preferences[birthdate]" id="" class="" placeholder="Birthdate">
						</div>
					</div>-->

					<div class="row birthday-row">
						<div class="col-md-2">
							<p class="text-color-text"> Birthday</p>
						</div>
						<div class="col-md-2 big-select">
							<select required name="preferences[birthday-day]" id="birthday-day">
								<option value="0">Day</option>
								<? for($i=1;$i<32;$i++):?>
									<option value="<?=$i?>"><?=$i?></option>
								<? endfor;?>
							</select>
						</div>
						<div class="col-md-5 big-select">
							<select required name="preferences[birthday-month]" id="birthday-month">
								<option value="0">Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">Juli</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="col-md-3 big-select">
							<select required name="preferences[birthday-year]" id="birthday-year">
								<option value="0">Year</option>
								<? for ($i=date('Y', time() ); $i > date('Y', (time()-60*60*24*365*100)); $i--):?>
									<option value="<?=$i?>" <? if($i == time()-60*60*24*365*18): ?>selected<?endif;?>><?=$i?></option>
								<? endfor;?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input required type="radio" name="preferences[sex]" id="sex-male" value="male"><label for="sex-male">Male</label>
							<input required type="radio" name="preferences[sex]" id="sex-female" value="female"><label for="sex-female">Female</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input required type="text" name="emailaddress" id="emailaddress" class="email" placeholder="Emailaddress">
						</div>
						<div class="col-md-6">
							<input required type="text" name="re-emailaddress" id="re-emailaddress" class="email" placeholder="Repeat emailaddress">
						</div>
					</div>
					<? /*
					<div class="row">
						<div class="col-md-6">
							<input required type="text" name="" id="" class="" placeholder="Password">
						</div>
						<div class="col-md-6">
							<input required type="text" name="" id="" class="" placeholder="Repeat password">
						</div>
					</div> */ ?>
					<div class="row">
						<div class="col-md-12"> 
							<p class="error" id="signup-error"></p>
						</div>
						<div class="col-md-12"> 
							<div class="float-left">
								<a href="#" id="registerform-submit" class="blue-btn primary-color-background primary-text-color-text">Sign up</a>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</form>
	</div>
			<!--<div class="preview-row event-background-color-background">
				<div class="steps">
					<div class="step">
						<span class="step-number primary-color-background text-color-text">1</span><span class="step-title">Tickets</span>
					</div>
					<div class="step active">
						<span class="step-number steps-color-background text-color-text">2</span><span class="step-title">Personal info</span>
					</div>
					<div class="step">
						<span class="step-number steps-color-background text-color-text">3</span><span class="step-title">Confirmation</span>
					</div>
					<div class="step">
						<span class="step-number steps-color-background text-color-text">4</span><span class="step-title">Payment</span>
					</div>
				</div>
			</div>
			<div class="preview-row event-background-color-background">
				<div class="left">
					<table class="event-info">
						<tr>
							<td class="text-color-text">Event:</td>
							<td class="event-info-node event-title primary-color-text">Qapital - Raw & Uncut</td>
							<td class="text-color-text">Date:</td>
							<td class="event-info-node subtext-color-text">5 April 2014</td>
						</tr>
						<tr>
							<td class="text-color-text">Venue:</td>
							<td class="event-info-node subtext-color-text">Ziggo Dome, Amsterdam</td>
							<td class="text-color-text">Event time:</td>
							<td class="event-info-node subtext-color-text">22:00 - 07:00</td>
						</tr>
					</table>
				</div>
				<!--<div class="right">
					<img src="<?=$base?>images/dashboard/dashboard-preview/180x180.gif" alt="" class="seatmap">
				</div>--
			</div>
				<div class="preview-row event-background-color-background">
					
					<h1>Log in to your account</h1>
					<form method="post" action="" id="loginform" novalidate="novalidate">
						<p class="error"></p>
						<input id="loginusername" type="text" required name="username" placeholder="Username">
						<input id="loginpassword" type="password" required name="password" placeholder="Password" value="">
						<input type="submit" name="login" value="Log in">
					</form>
					<div id="line">
						<h2>or sign in using social media</h2>
					</div>
					<div id="socialmedialogin">
						<a id="facebooklogin-tickets" <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.str_replace('%2F1', '', $fb_login_url['url']).'"' : 'data-id="'.$fb_login_url['id'].'"' )?> >Log in</a><a id="twitterlogin" href="">Log in</a><a id="linkedinlogin" href="">Log in</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>-->
<!--<h1>Tickets bestellen</h1>
<div class="row" id="steps">
	<div class="col-sm-3">
		<h2>1. Tickets</h2>
	</div>
	<div class="col-sm-3">
		<h2 class="active">2. Login</h2>
	</div>
	<div class="col-sm-3">
		<h2>3. Overzicht</h2>
	</div>
	<div class="col-sm-3">
		<h2>4. Afrekenen</h2>
	</div>
</div>
<div id="step3" class="row steps">
	<div class="col-sm-6">
	</div>
</div>-->
<?=$scripts?>