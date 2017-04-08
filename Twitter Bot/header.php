<?php
/*******************************************************************************\
** This file handles the sessions so the page will die on load if the user is  **
** logged in as an admin to the WebUI.                                         **
\*******************************************************************************/
session_start();
	if($_SESSION['is_logged_in'] != "OK/200") {
		die("<html><head><title>Login to TwitNet</title></head><body>
			Please login.<br />
			<form action=\"./login.php\" method=\"post\">
				Username: <input type=\"text\" name=\"username\" /><br />
				Password: <input type=\"password\" name=\"password\" />
				<input type=\"submit\" value=\"Login\" />
			</form></body></html>"); // die and show login form.
	}

?>
<html>
	<head>
		<title>TwitNet Control Panel</title>
	</head>
	<body style="font-family:monospace; font-size:12pt;">
		<font style="font-size:28pt; font-weight:bold; color:#0094DE;">TwitNet C&C WebUI</font><br />Twitter Botnet C&C<hr />
			<strong>Menu: </strong>
			<a href="./index.php">Control Panel</a> | 
			<a href="./macros.php">Macros</a>
		<hr /><br />
