<? if(!isset($editPreference)): ?>
<table>
	<thead>
		<tr>
			<th>title</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($wizardsteps as $value): ?>
			<tr>
				<td><?=$value['Descript']; ?></td>
				<td><a href="<?=$sys_base?>wizards/?wizard=<?=$wizard?>&amp;wizardstep=<?=$wizardstep?>&amp;edit=<?=$value['ID']?>">Edit</a></td>
			</tr>
		<?  endforeach; ?>
	</tbody>
</table>
<? endif; ?>

<? if(isset($edit)):
	foreach($wizardsteps as $wizardstep){
		if($wizardstep['ID'] == $edit){
			$current_edit = $wizardstep;
		}
	}
?>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="descript" id="descript" value="<?=(isset($current_edit)? $current_edit['Descript'] : '')?>" />
			<input type="hidden" name="edit" id="edit" value="edit" />
			<input type="hidden" name="preference_id" id="preference_id" value="<?=$current_edit['ID']?>" />
		<? if(isset($wizard)):?>
			<input type="hidden" name="wizard" id="wizard" value="<?=$wizard?>" />
		<? endif; ?>
		<select name="validator" id="validator">
			<? foreach ($validators as $key => $value): ?>
				<option value="<?=$value['ID']?>" <? if(isset($current_edit) && $current_edit['typeOfPreference'] == $value['ID']): ?>selected<? endif; ?> ><?=$value['Naam']?></option>
			<? endforeach; ?>
		</select> 
		<textarea name="help_content" id="help_content" cols="30" rows="10" style="height: auto;"><?=(isset($current_edit)? $current_edit['HelpContent'] : '')?></textarea>
		<!--<input type="checkbox" name="required" value="1" id="required-checkbox" /><label for="required-checkbox">Required</label>-->
		<input type="submit" name="" id="" value="Save" />
	</form>
<? else: ?>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="descript" id="descript" value="" />
		<? if(isset($wizard)):?>
			<input type="hidden" name="wizard" id="wizard" value="<?=$wizard?>" />
		<? endif; ?>
		<select name="validator" id="validator">
			<? foreach ($validators as $key => $value): ?>
				<option value="<?=$value['ID']?>" <? if($value['Naam'] == 'String'): ?>selected<? endif; ?> ><?=$value['Naam']?></option>
			<? endforeach; ?>
		</select>
		<textarea name="help_content" id="help_content" cols="30" rows="10" style="height: auto;"></textarea>
		<!--<input type="checkbox" name="required" value="1" id="required-checkbox" /><label for="required-checkbox">Required</label>-->
		<input type="submit" name="" id="" value="Save" />
	</form>
<? endif; ?>