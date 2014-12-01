<div id="content" class="settings-form wizard-form">
	<div class="row" id="navigation-row">
		<div class="col-lg-12 col-sm-12 col-md-12 full-block" id="tickets-sold">
			<? $i=1; foreach ($fields as $key => $value): ?>
				<div class="steps-buttons <?=($step == $i ? 'active' : '')?>" id="step-<?=$i?>">
					<a href="<?=$base?>dashboard/settings/<?=$i?>"><div class="step"><?=$i?></div></a>
					<h2><?=$value['Name']?></h2>
				</div>
			<? $i++; endforeach; ?>
		</div>
	</div>
	<!--<div class="row" id="">
		<div class="col-md-12 full-block">
			<div class="left-padding"><h2>Customize your tickets page</h2></div>
		</div>
	</div>-->
	<form action="<?=$base?>dashboard/settings/<?=$step?>" method="post" enctype='multipart/form-data'>
		<input type="hidden" name="step" id="step" value="<?=$step?>" />
		<? foreach($fields[($step-1)]['fields'] as $key => $value): ?>
			<div class="row">
				<div class="col-md-6">
					<div class="left-padding"><p><?=$value['Descript']?><?=($value['SystemPreference'] == '1' ? '*' : '')?><? if($value['HelpContent'] != '' && $value['HelpContent'] != '0'): ?><a href="#popup-help" class="popup-help" data-type="help" data-id="<?=$value['ID']?>"><img src="<?=$base?>images/questionmark.png" alt="question"></a><? endif; ?></p></div>
				</div>
				<div class="col-md-6">
					<div class="right-padding">
						<? 
							switch ($value['Code']) {
								case 'url':
									echo '<input type="text" name="preferences['.($step-1).']['.$value['ID'].']" class="url" value="'.(isset($settings[$value['ID']]) ? $settings[$value['ID']]['Value'] : '').'">';
									break;
								case 'file': ?>
									<a href="#" class="upload-button" onclick="$(this).parent().children('#upload-<?=$value['ID']?>').click();">Upload item<img src="<?=$base?>images/dashboard/icon/upload.png" /></a>
									<input id="upload-<?=$value['ID']?>" name="preferences[<?=$value['ID']?>]" type="file" onchange="$('#upload-<?=$value['ID']?>-p').html( $(this).val().replace('C:\\fakepath\\', '') )">
									<p id="upload-<?=$value['ID']?>-p"><?=(isset($settings[$value['ID']]) ? $settings[$value['ID']]['Value'] : '')?></p>
								<?	break;
								default:
									echo '<input type="text" name="preferences['.($step-1).']['.$value['ID'].']" value="'.(isset($settings[$value['ID']]) ? $settings[$value['ID']]['Value'] : '').'">';
									break;
							}
						?>
					</div>
				</div>
			</div>
		<? endforeach; ?>
		<div class="row">
			<div class="clear line"></div>
			<div class="col-md-12">
				<div class="left-padding">
					<p>* required to publish events publicly.</p>
				</div>
			</div>
			<div class="col-md-12">
				<div class="left-padding"><input type="submit" value="Save and edit" name="save-and-edit" /></div>
			</div>
			<div class="col-md-12">
				<div class="left-padding"><input type="submit" value="Next step" name="next-step" /></div>
			</div>
		</div>
	</form>