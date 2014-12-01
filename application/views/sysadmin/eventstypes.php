<table>
	<thead>
		<tr>
			<th>title</th>
			<th>edit</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($eventstypes as $value): ?>
			<tr>
				<td><?=$value['Type']; ?></td>
				<td><a href="<?=$sys_base?>categories/<?=$value['ID']?>">Manage subcats</a></td>
			</tr>
		<?  endforeach; ?>
	</tbody>
</table>

<form action="" method="post" enctype="multipart/form-data">
	<input type="text" name="type" id="type" value="" />
	<? if(isset($main_id)):?>
		<input type="hidden" name="main_id" id="main_id" value="" />
	<? endif; ?>
	<input type="submit" name="" id="" value="Save" />
</form>