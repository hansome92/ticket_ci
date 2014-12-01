<table>
	<thead>
		<tr>
			<th>title</th>
			<th>money per ticket</th>
			<th>image</th>
			<th>valid until:</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($sponsorships as $sponsorship): if(isset($sponsorship['preferences']['title'])):?>
			<tr>
				<td><?=$sponsorship['preferences']['title']['Value']; ?></td>
				<td>&euro;<?=$sponsorship['preferences']['price']['Value']; ?></td>
				<td><? if(isset($sponsorship['preferences']['date'])):?><?=$sponsorship['preferences']['date']['Value']; ?><? endif; ?></td>
				<td><?=$sponsorship['preferences']['image']['Value']; ?></td>
			</tr>
		<? endif; endforeach; ?>
	</tbody>
</table>

<form action="" method="post" enctype="multipart/form-data">
	<input type="text" name="title" id="title" value="" />
	<input type="text" name="price" id="price" value="0.01" />
	<input type="file" name="image" id="image" value="" />
	<input type="date" name="date" id="date" value="<?=date('d-m-Y', time());?>" />
	<input type="submit" name="" id="" value="Save" />
</form>