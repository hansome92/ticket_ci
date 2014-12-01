<table>
	<thead>
		<tr>
			<th>title</th>
			<th>edit</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($wizards as $value): ?>
			<tr>
				<td><?=$value['Name']; ?></td>
				<td><a href="<?=$sys_base?>wizards/?wizard=<?=$value['ID']?>">Manage wizardsteps</a></td>
			</tr>
		<?  endforeach; ?>
	</tbody>
</table>

<form action="" method="post" enctype="multipart/form-data">
	<input type="text" name="name" id="name" value="" />
	<? if(isset($main_id)):?>
		<input type="hidden" name="main_id" id="main_id" value="" />
	<? endif; ?>
	<input type="submit" name="" id="" value="Save" />
</form>