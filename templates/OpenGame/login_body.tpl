<div id="main">
	<div id="login">
		<div id="login_input">
			<form name="formular" action="{SERVER_URL}login.php" method="post">
				<table width="400" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr style="vertical-align: top;">
							<td style="padding-right: 4px;">
								{User_name} <input name="username" value="" type="text">
								{Password} <input name="password" value="" type="password">
							</td>
						</tr>
						<tr>
							<td style="padding-right: 4px;">
								{Remember_me} <input name="rememberme" type="checkbox"><input name="submit" value="{Login}" type="submit">
							</td>
						</tr>
						<tr>
							<td style="padding-right: 4px;">
								<a href="lostpassword.php">{PasswordLost}</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<div id="mainmenu" style="margin-top: 20px;">
		<a href="reg.php" title="{log_reg}">{log_reg}</a>
		<a href="{forum_url}" title="Forum">Forum</a>
		<a href="contact.php" title="Contact">Contact</a>
		<a href="credit.php" title="{log_cred}">{log_cred}</a>
	</div>
	<div id="rightmenu" class="rightmenu">
		<center>
			<div id="title">{log_welcome} {servername}</div>
				<div id="content">
						<div id="text1">
							<div style="text-align: left;"><strong>{servername}</strong> {log_desc} {servername}.</div>
						</div>
					<div id="register" class="bigbutton" onclick="document.location.href='reg.php';"><font color="#cc0000">{log_toreg}</font></div>
					<div id="text2">
					<div id="text3">
						<center>
							<b><font color="#00cc00">{log_online}: </font>
							<font color="#c6c7c6">{online_users}</font> - <font color="#00cc00">{log_lastreg}: </font>
							<font color="#c6c7c6">{last_user}</font> - <font color="#00cc00">{log_numbreg}:</font> <font color="#c6c7c6">{users_amount}</font></b>
						</center>
					</div>
				</div>
			</div>
		</center>
	</div>
</div>