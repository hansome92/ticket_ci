<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tibbaa - Second generation ticketing</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=$base?>images/favicon.ico"/>

    <link href="<?=$base?>css/<?=$asset_url?>bootstrap.css" rel="stylesheet">
    <link href="<?=$base?>css/<?=$asset_url?>style.css" rel="stylesheet">
	<link href="<?=$base?>css/<?=$asset_url?>menu.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=$base?>css/<?=$asset_url?>jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="<?=$base?>css/<?=$asset_url?>jquery.bxslider.css" />
	
	<script type="text/javascript">var base_url = "<?=$base?>"; var meta = "<?=(isset($meta) ? $meta : '');?>";</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script src="<?=$base?>js/<?=$asset_url?>custom.js"></script>
	<script src="<?=$base?>js/<?=$asset_url?>jquery.fancybox.js"></script>
	<script src="<?=$base?>js/<?=$asset_url?>jquery.bxslider.js"></script>
	<script src="<?=$base?>js/<?=$asset_url?>jquery.validate.js"></script>
	<script src="<?=$base?>js/<?=$asset_url?>scripts.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?=$base?>js/<?=$asset_url?>html5shiv.js"></script>
      <script src="<?=$base?>js/<?=$asset_url?>respond.js"></script>
    <![endif]-->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */
			$('.login').fancybox();
			$('.signup').fancybox();
			$('.forgot-password').fancybox();

			$(function(){
			  $('#section0').css({ height: $(window).innerHeight()-100 });
			  $(window).resize(function(){
			    $('#section0').css({ height: $(window).innerHeight()-100 });
			  });
			});

			$('.bxslider').bxSlider({
			  mode: 'horizontal',
			  controls: true,
			  captions: true
			});

			if(window.location.hash == '#login') {
				$(".login").click();
			}
		});
	</script>
	</head>
<body>
	<div id="wrapper">
		<div id="top">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-xs-12" id="top-logo">
						<a href=""><img src="<?=$base?>images/<?=$asset_url?>logo.png" alt="" /></a>
					</div>
					<div class="col-sm-9 col-xs-12">
						<nav class="clearfix top visible-xs">
							<span class="pull">Menu</span>
							<ul class="clearfix">
								<? if($logged_in === true): ?>
									<li><a href="<?=$base?>dashboard" class="signup">Dashboard</a></li>
								<? else: ?>
									<li><a href="#signup" class="signup">Sign up</a></li>
									<li><a href="#login" class="login">Sign in</a></li>
								<? endif; ?>
							</ul>
						</nav>
						<nav class="clearfix top hidden-xs">
							<span class="pull">Menu</span>
							<ul class="clearfix">
								<? if($logged_in === true): ?>
									<li><a href="<?=$base?>dashboard" class="signup">Dashboard</a></li>
								<? else: ?>
									<li><a href="#signup" class="signup">Sign up</a></li>
									<li><a href="#login" class="login">Sign in</a></li>
								<? endif; ?>
								
								<li><a href="" class="languages">Languages
								<img src="<?=$base?>images/<?=$asset_url?>icon-world.png" alt="">
								</a>
									<ul class="languages-space">
									<div class="languages-dd">
										<?foreach ($active_languages as $key => $value):?>
											<li><a href='#'>english</a></li>
										<? endforeach;?>
									</div>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>

		<div id="login" style="display:none;">
			<div class="lightbox-content hidden-xs">
				<form id="loginform" method="post" action="">
					<div class="lightbox-head">
						<img src="<?=$base?>images/<?=$asset_url?>lightbox-logo.png">
					</div>
					<div class="lightbox-mid">
						<div class="stripes">
							<span class="lightbox-title">Sign in</span>
						</div>
						<p class="error"></p>
						<input type="text" required placeholder="E-mailadres" class="username" id="loginusername" name="username"/>
						<input type="password" required placeholder="Password" class="password" id="loginpassword" name="password"/>
						<input type="submit" value="Sign in" class="signin"/>
						<ul class="xtra_btns">
							<li href="#"><a href="#forgot-password" class="forgot-password">Forgot password?</a></li>
							<li href="#"><a href="#signup" class="signup">Sign up</a></li>
						</ul>
						<!--<div class="stripes">
							<span class="lightbox-title2">Use social media</span>
						</div>
						<ul class="social_btns">
							<li href="#"><a <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.$fb_login_url['url'].'"' : 'data-id="'.$fb_login_url['id'].'"' )?>>
								<img src="<?=$base?>images/<?=$asset_url?>icon-fb.png" alt="">Facebook
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-twt.png" alt="">Twitter
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-li.png" alt="">Linked in
							</a></li>
						</ul>-->
					</div>
				</form>
			</div>
			<div class="lightbox-content-mob visible-xs">
				<form id="loginform-mobile" method="post" action="">
					<div class="lightbox-head">
						<img src="<?=$base?>images/<?=$asset_url?>lightbox-logo.png">
					</div>
					<div class="lightbox-mid">
						<div class="stripes">
							<span class="lightbox-title">Sign in</span>
						</div>
						<p class="error"></p>
						<input type="text" value="E-mailadres" class="username" id="loginusername" name="username" />
						<input type="password" value="Password" class="password" id="loginpassword" name="password" />
						<input type="submit" value="Sign in" class="signin"/>
						<ul class="xtra_btns">
							<li href="#"><a href="#forgot-password" class="forgot-password">Forgot password?</a></li>
							<li href="#"><a href="#signup" class="signup">Sign up</a></li>
						</ul>
						<!--<div class="stripes">
							<span class="lightbox-title2">Use social media</span>
						</div>
						<ul class="social_btns-mob">
							<li href="#"><a <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.$fb_login_url['url'].'"' : 'data-id="'.$fb_login_url['id'].'"' )?>>
								<img src="<?=$base?>images/<?=$asset_url?>icon-fb.png" alt="">
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-twt.png" alt="">
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-li.png" alt="">
							</a></li>
						</ul>-->
					</div>
				</form>
			</div>
		</div><!-- #login -->
		

		<div id="signup" style="display:none;">
			<div class="lightbox-content hidden-xs">
				<form id="registerform" method="post" action="">
					<div class="lightbox-head">
						<img src="<?=$base?>images/<?=$asset_url?>lightbox-logo.png">
					</div>
					<div class="lightbox-mid">
						<div class="stripes">
							<span class="lightbox-title">Sign up</span>
						</div>
						<p class="error"></p>
						<input type="text" required placeholder="E-mailadres" class="username email" id="" name="username" />
						<input type="password" required placeholder="Password" class="password" id="" name="password" />
						<input type="submit" value="Sign up" class="signin"/>
						<ul class="xtra_btns">
							<li href="#"><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
							<li href="#"><a href="#login" class="login">Already have an account?</a></li>
						</ul>
						<!--<div class="stripes">
							<span class="lightbox-title2">Use social media</span>
						</div>
						<ul class="social_btns">
							<li href="#"><a <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.$fb_login_url['url'].'"' : 'data-id="'.$fb_login_url['id'].'"' )?>>
								<img src="<?=$base?>images/<?=$asset_url?>icon-fb.png" alt="">Facebook
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-twt.png" alt="">Twitter
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-li.png" alt="">Linked in
							</a></li>
						</ul>-->
					</div>
				</form>
			</div>
			<div class="lightbox-content-mob visible-xs">
				<form id="registerform-mobile" method="post" action="">
					<div class="lightbox-head">
						<img src="<?=$base?>images/<?=$asset_url?>lightbox-logo.png">
					</div>
					<div class="lightbox-mid">
						<div class="stripes">
							<span class="lightbox-title">Sign up</span>
						</div>
						<p class="error"></p>
						<input type="text" required value="E-mailadres" class="username email" id="" name="username" />
						<input type="password" required value="Password" class="password" id="" name="password" />
						<input type="submit" value="Sign in" class="signin"/>
						<ul class="xtra_btns">
							<li href="#"><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
							<li href="#"><a href="#login" class="login">Already have an account?</a></li>
						</ul>
						<!--<div class="stripes">
							<span class="lightbox-title2">Use social media</span>
						</div>
						<ul class="social_btns-mob">
							<li href="#"><a <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.$fb_login_url['url'].'"' : 'data-id="'.$fb_login_url['id'].'"' )?>>
								<img src="<?=$base?>images/<?=$asset_url?>icon-fb.png" alt="">
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-twt.png" alt="">
							</a></li>
							<li href="#"><a href="#">
								<img src="<?=$base?>images/<?=$asset_url?>icon-li.png" alt="">
							</a></li>
						</ul>-->
					</div>
				</form>
			</div>
		</div><!-- #register -->
		<div id="forgot-password" style="display:none;">
			<div class="lightbox-content hidden-xs">
				<form id="forgot-password-form" method="post" action="">
					<div class="lightbox-head">
						<img src="<?=$base?>images/<?=$asset_url?>lightbox-logo.png">
					</div>
					<div class="lightbox-mid">
						<div class="stripes">
							<span class="lightbox-title">Forgot password</span>
						</div>
						<p class="error"></p>
						<input type="text" required placeholder="E-mailadres" class="username email" id="" name="username" />
						<p id="pass-lost-result">We will send you a new password in your mailbox as soon as you send your emailaddress to us.</p>
						<input type="submit" value="Send password!" class="signin"/>
						<ul class="xtra_btns">
							<li href="#"><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
							<li href="#"><a href="#login" class="login">Hey! I remember!</a></li>
						</ul>
					</div>
				</form>
			</div>
		</div><!-- #register -->
		<div id="push"></div>