<div class="container content">
<!--<ul id="steps">
	<? foreach($wizard as $step):?>
		<li><a href="#"><?=$step['name']?></a></li>
	<? endforeach; ?>
</ul>-->

	<!--<? $i = 0; foreach($wizard as $step): ?>
		<form method="post" action="" id="step<?=$i+1;?>form wiz-form" class="wiz-form">
			<table id="step<?=$i+1;?>">
				<? if(isset($step['fields'])): foreach($step['fields'] as $preference):?>
					<tr class="col-md-12 col-xl-12 col-l-12">
						<th class="col-md-3 col-xl-3 col-l-3"><?=$preference['Descript']?></th>
						<td class="col-md-3 col-xl-3 col-l-3"><input type="<?if($preference['Code'] == 'password'):?>password<?else:?>text<?endif;?>" name='preferences[<?=$preference[0]?>]' <?if($preference['typeOfPreference'] != 0 && isset($preference['Code'])):?>class="<?=$preference['Code']?>"<? endif;?> <?if($preference['SystemPreference'] == 1):?>required<?endif;?>/></td>
					</tr>
				<? endforeach; endif;?>
				<tr>
					<td><?if($i != 0):?><a href="#" class="back">&laquo; </a><?endif; ?></td>
					<td><a href="#" class="next<?if(end($wizard) == $step):?>-last<?endif;?>" onclick="$('#wiz-form').submit();"><?if(end($wizard) == $step):?>Finish<? else: ?>Volgende<?endif;?></a></td>
				</tr>
			</table>
		</form>
	<? $i++; endforeach; ?>
</div>-->

<h1>New event</h1>
<div>
	<form class="" method="post" action="<?=$base?>dashboard/newevent">
		<table>
			<? $i = 0; foreach($wizard as $step): ?>
				<? if(isset($step['fields'])): foreach($step['fields'] as $preference):?>
					<tr>
						<th><?=$preference['Descript']?></th>
						<td class=""><input type="<?if($preference['Code'] == 'password'):?>password<?else:?>text<?endif;?>" name='preferences[<?=$preference[0]?>]' <?if($preference['typeOfPreference'] != 0 && isset($preference['Code'])):?>class="<?=$preference['Code']?>"<? endif;?> <?if($preference['SystemPreference'] == 1):?>required<?endif;?>/></td>
					</tr>
				<? endforeach; endif;?>
			<? $i++; endforeach; ?>
			<!--<tr>
				<th>Title</th>
				<td><input type="radio" name="sex" class="" required value="male"/>Mr. <input type="radio" name="sex" value="female" />Ms.</td>
			</tr>
			<tr>
				<th>Name</th>
				<td><input type="text" name="firstname" required class="" placeholder="First name" /><input type="text" name="lastname" placeholder="Last name" /></td>
			</tr>
			<tr>
				<th>Address</th>
				<td><input type="text" name="address"  class="" placeholder="Address" /><input type="text" name="househumber" placeholder="House number" /></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="text" name="postalcode" class="" placeholder="Postal Code" /><input type="text" name="city" placeholder="City" /></td>
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
				<td><input type="text" name="phonenumber" placeholder="Phonenumber" /></td>
			</tr>
			<tr>
				<th>Newsletter</th>
				<td><input type="checkbox" name="newsletter" />Yes, I want to sign up for the newsletter.</td>
			</tr>-->
		</table>
	</form>
	<hr />
	<div class="floatright">
		<a class="create-event" onclick="$('form').submit();">Create</a>
	</div>
</div>