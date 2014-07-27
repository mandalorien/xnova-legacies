<center>
	<br>
		<form action='annonce.php?action=enregistrer' method='post'>
			<table width='600'>
						<tr>
							<td class='c' colspan='10' align='center'><b><font color='white'>{ann_add_action}</font></b></td>
						</tr>
						<tr>
							<td class='c' colspan='10' align='center'><b>{ann_sell}</font></b></td>
						</tr>
						<tr>
							<th colspan='5'>{Metal}</th><th colspan='5'><input type='texte' value='0' name='metalvendre' /></th>
						</tr>
						<tr>
							<th colspan='5'>{Crystal}</th><th colspan='5'><input type='texte' value='0' name='cristalvendre' /></th>
						</tr>
						<tr>
							<th colspan='5'>{Deuterium}</th><th colspan='5'><input type='texte' value='0' name='deutvendre' /></th>
						</tr>
						<tr>
							<td class='c' colspan='10' align='center'><b>{ann_buy}</font></b></td>
						</tr>
						<tr>
							<th colspan='5'>{Metal}</th><th colspan='5'><input type='texte' value='0' name='metalsouhait' /></th>
						</tr>
						<tr>
							<th colspan='5'>{Crystal}</th><th colspan='5'><input type='texte' value='0' name='cristalsouhait' /></th>
						</tr>
						<tr>
							<th colspan='5'>{Deuterium}</th><th colspan='5'><input type='texte' value='0' name='deutsouhait' /></th>
						</tr>
						<tr>
							<th colspan='10'><input type='submit' name="ajout" value='{ann_valide}' /></th>
						</tr>
			</table>
		<form>