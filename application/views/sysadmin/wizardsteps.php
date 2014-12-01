<table>
	<thead>
		<tr>
			<th>title</th>
			<th>edit</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($wizardsteps as $value): ?>
			<tr>
				<td><?=$value['Name']; ?></td>
				<td><a href="<?=$sys_base?>wizards/?wizard=<?=$wizard?>&amp;wizardstep=<?=$value['ID']?>">Manage wizardsteps</a></td>
			</tr>
		<?  endforeach; ?>
	</tbody>
</table>

<form action="" method="post" enctype="multipart/form-data">
	<input type="text" name="name" id="name" value="" />
	<? if(isset($wizard)):?>
		<input type="hidden" name="wizard" id="wizard" value="<?=$wizard?>" />
	<? endif; ?>
	<input type="submit" name="" id="" value="Save" />
</form>