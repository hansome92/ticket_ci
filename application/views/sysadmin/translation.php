

	<div class="col-sm-12 col-lg-12 nopadding-left ">
		<h2 class="sub-header">Talen</h2>
		<div class="table-responsive">
			<? if(isset($languages)): ?>
				<table>
					<thead>
						<tr>
							<th>Language</th>
							<th>Active</th>
							<th>Completely translated</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($languages as $key => $value): ?>
							<? if($value['StandardLanguage'] != '1'): ?>
								<tr>
									<td><a href="<?=sys_url();?>translation/<?=$value['ID'];?>"><?=$value['Code'];?></a></td>
									<td><?=( isset($value['Active']) && $value['Code'] == '1' ? 'Active' : 'Inactive');?></td>
									<td><?=( isset($value['Complete']) && $value['Complete'] == '1' ? 'Complete' : 'Incomplete');?></td>
								</tr>
							<? endif; ?>
						<?endforeach;?>
					</tbody>
				</table>
			<? elseif(isset($language)):?>
				<form method="post" action="<?=$sys_base?>translation/<?=$langid?>" enctype="multipart/form-data">
					<? foreach( $language['translates'] as $key => $value ): ?>
						<div class="row">
							<div class="col-md-6">
								<input type="text" name="stringtranslations[<?=$value['ID']?>][original]" value="<?=(isset($value['improvedString']) && $value['improvedString'] != '' ? $value['improvedString'] : $value['String'])?>" />
							</div>
							<div class="col-md-6">
								<input type="text" name="stringtranslations[<?=$value['ID']?>][translated]" value="<?=(isset($value['translated']) ? $value['translated'] : '')?>" />
							</div>
						</div>
					<? endforeach; ?>
					<input type="submit" value="Save">
				</form>
			<? endif; ?>
		</div>
	</div>
</div>