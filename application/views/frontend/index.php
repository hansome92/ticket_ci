<div class="fullwidth" id="section0">
			<div class="container">
				<div class="col-xs-12">
				
				<div class="content">
					<h1><?=_e('Ticketing generation 2.0');?></h1>
					<span class="subtitle1"><?=_e('Create your events effortlessly');?></span>
					<span class="subtitle2"><?=_e('Manage and customize your own ticket sales page');?></span>
					
					<div class="head_btns">
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-2 col-md-offset-4 col-sm-offset-2">
						  <a <? if($logged_in === true): ?>href="<?=$base?>dashboard/newevent"<? else: ?>class="login" href="#login"<? endif; ?>><div class="create_btn"><?=_e('create event');?></div></a>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-2">
						  <a href="#section4" id="contact"><div class="getintouch_btn"><?=_e('get in touch');?></div></a>
						</div>
					</div>
					</div>
				</div>

				</div>
			</div><!-- container -->
			<div id="to_one" class="hidden-xs"></div>
		</div><!-- end of section -->

		<div class="fullwidth" id="section1">
			<div class="container">
				<div class="col-xs-12">

				<div class="content2">
				<img src="<?=$base?>images/<?=$asset_url?>icon-promoters.png" alt="" />
				<h1><?=_e('Perfect for your event');?></h1>
				<h2><?=_e('You have an event, we have a platform');?></h2>
				<ul class="vink-list">
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Create your ticketshop within minutes');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Start earning money directly on top of your tickets');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Design your own ticketshop layout or use our templates');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Free to register and create an event');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Offer several types of tickets to your customers');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Our system and website is optimalized for mobile');?></li>
					<li><img src="<?=$base?>images/<?=$asset_url?>icon-vink.png"><?=_e('Gather your and analyze your event data');?></li>
				</ul>
				</div>
			

				</div>
			</div><!-- container -->
			<div id="to_two"></div>
		</div><!-- end of section -->

		<div class="fullwidth" id="section2">
			<div class="container">
				<div class="col-xs-12">

				<div class="content2">
				<h1><?=_e('How it works');?></h1>
				<h2><?=_e('Create event / Customize ticket page / Sell tickets / Scan tickets');?></h2>
					<ul class="bxslider">
					  <li><img src="<?=$base?>images/<?=$asset_url?>step1.png" alt=""/></li>
					  <li><img src="<?=$base?>images/<?=$asset_url?>step2.png" alt=""/></li>
					  <li><img src="<?=$base?>images/<?=$asset_url?>step3.png" alt=""/></li>
					  <li><img src="<?=$base?>images/<?=$asset_url?>step4.png" alt=""/></li>
					</ul>
				</div>
			

				</div>
			</div><!-- container -->
			<div id="to_three"></div>
		</div><!-- end of section -->

		<div class="fullwidth" id="section3">
			<div class="container">
				<div class="col-xs-12">

				<div class="content2">
				<h1><?=_e('Analyze your event data');?></h1>
				<h2><?=_e('Get an easy overview of all your statistics');?></h2>
					<img src="<?=$base?>images/<?=$asset_url?>analyze1.png" alt="">
				</div>
			

				</div>
			</div><!-- container -->
			<div id="to_four"></div>
		</div><!-- end of section -->

		<div class="fullwidth" id="section4">
			<div class="container">
				<div class="col-xs-12">
					<div class="content2">
						<h1><?=_e('Get in touch');?></h1>
						<h2><?=_e('For questions feel free to contact us');?></h2>
						<form class="getintouch">
							<div class="col-xs-12 col-sm-4">
								<input type="text" placeholder="<?=_e('Enter Your Name');?>"/>
							</div>
							<div class="col-xs-12 col-sm-4">
								<input type="text" placeholder="<?=_e('Enter Your Email');?>"/>
							</div>
							<div class="col-xs-12 col-sm-4">
								<input type="text" placeholder="<?=_e('Enter Your Subject');?>"/>
							</div>
							<div class="col-xs-12">
								<textarea placeholder="<?=_e('Enter Your Message');?>"/></textarea>
							</div>
							<div class="col-xs-12">
								<input type="submit" value="<?=_e('Send');?>" />
							</div>
						</form>
						</div>
					</div>
				</div>
			</div><!-- container -->
		</div><!-- end of section --> 