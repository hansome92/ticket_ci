<div id="content">
	<form action="<?=$base?><?=$module?>/login" method="post" id="step1form">
		<table id="step1">
			<tr>
				<td><?=_e('Username');?></td>
				<td><input name="naam" type="text" required /></td>
			</tr>
			<tr>
				<td><?=_e('Password');?></td>
				<td><input name="password" type="password" required /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<a href="<?=$base?><?=$module ?>/register"><?=_e('Register');?></a>
					<input type="submit" value="<?=_e('Login');?>" />
				</td>
			</tr>
		</table>
	</form>
</div>