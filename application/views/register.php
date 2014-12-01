<div id="content">
	<? print_r($cur_wizard); ?>
	<form action="" method="post" id="step1form">
		<table id="step1">
			<tr>
				<td>Gebruikersnaam</td>
				<td><input name="naam" type="text" required /></td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input name="password" type="pass" required /></td>
			</tr>
			<tr>
				<td></td>
				<td><a href="<?=$base?>promoter/register">Registreren</a><input type="submit" value="Inloggen" /></td>
			</tr>
		</table>
	</form>
</div>