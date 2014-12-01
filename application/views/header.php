 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<? if(isset($event)):?>
    	<title><?=$event['EventName']?> | Tibbaa dev</title>
	    <meta property="fb:app_id" content="444108919055890"> 
	    <meta property="og:type" content="website"> 
	    <meta property="og:title" content="<?=$event['EventName']?>"> 
	    <meta property="og:image" content=""> 
	    <meta property="og:description" content="I'm going to <?=$event['EventName']?>! Are you coming too?"> 
	    <meta property="og:url" content="<?=$base?>event/<?=$meta?>">
	<?else:?>
    	<title>Tibbaa dev</title>
    	<link rel="shortcut icon" type="image/x-icon" href="<?=$base?>images/favicon.ico"/>
	<?endif;?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link href="<?=$base?>css/bootstrap.css" rel="stylesheet">
    <link href="<?=$base?>css/formelements.css" rel="stylesheet">
    <link href="<?=$base?>css/style.css" rel="stylesheet">
	<link href="<?=$base?>css/menu.css" rel="stylesheet">


	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="<?=$base?>js/jquery.validate.js"></script>
	<script src="<?=$base?>js/custom.js"></script>
	<script type="text/javascript">var base_url = "<?=$base?>"; var meta = "<?=(isset($meta) ? $meta : '');?>";</script>
	<script src="<?=$base?>js/chart.js"></script>
	<script src="<?=$base?>js/scripts.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?=$base?>js/html5shiv.js"></script>
      <script src="<?=$base?>js/respond.js"></script>
    <![endif]-->
</head>
<body <?=(isset( $homepage ) && $homepage == true ? 'class="bodyhome"' : '') ?>
	<div id="wrapper">
		<div id="overlay"></div>
		<? if($logged_in === false): ?>
			<div id="login-screen" class="overlay-content">
				<img src="<?=$base?>images/logo.png">
				<h1>Log in to your account</h1>
				<p class="error"></p>
				<form method="post" action="#" id="loginform">
					<input id="loginusername" type="text" name="username" placeholder="E-mailadres" />
					<input id="loginpassword" type="password" name="password" placeholder="Password" value="" />
					<input type="submit" name="login" value="Log in" />
				</form>
				<div id="line">
					<h2>or sign in using social media</h2>
				</div>
				<div><a href="#" id="register-show">Register</a></div>
				<div></div>
				<div id="socialmedialogin">
					<a id="facebooklogin" <?=(isset($fb_login_url) && isset($fb_login_url['url']) && $fb_login_url['url'] != '' ? 'href="'.$fb_login_url['url'].'"' : 'data-id="'.$fb_login_url['id'].'"' )?> >Log in</a><a id="twitterlogin" href="">Log in</a><a id="linkedinlogin" href="">Log in</a>
				</div>
			</div>
			<div id="register-screen" class="overlay-content">
				<h1>Register</h1>
				<p class="error"></p>
				<form method="post" action="#" id="registerform">
					<input id="loginusername" type="text" name="username" required class="email" placeholder="E-mailadres" />
					<input id="loginpassword" type="password" name="password" required placeholder="Password" value="" />
					<input type="submit" name="register" value="Register" />
				</form>
			</div>
		<?endif;?>

		<div id="top">
			<div class="fullwidth">
				<div class="floatleft" id="top-logo">
					<a href="<?=$base?>"><img src="<?=$base?>images/logo.png" /></a>
				</div>
				<div class="floatright">
					<nav class="clearfix top">
						<span class="pull">Menu</span>
						<ul class="clearfix">
							<li class="active"><a href="<?=$base?>">home</a></li>
							<li><a href="<?=$base?>events">events</a></li>
							<? if($logged_in === true):?>
								<li><a href="<?=$base?>dashboard">account</a></li>
								<li><a href="<?=$base?>logout">logout</a></li>
							<? else: ?>
								<li class="loginknop"><a>login</a></li>
							<? endif; ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div id="push"></div>