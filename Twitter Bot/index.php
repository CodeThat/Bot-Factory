<?php
include('./header.php');
include('./functions.php');
?>
<form action="doit.php" method="post">
<input type="text" name="input_data" />
<select name="action">
	<option value="alltweet">All Tweet</option>
	<option value="allfollow">All Follow</option>
</select>
<input type="submit" value="Doit!" />
</form>
<br />
<b>Displaying 5/<?php echo database_count_bots(); ?> bots.</b>
<table border='1'><tr>
<td><b>Username</b></td>
<td><b>User ID</b></td>
<td><b>Member Since</b></td>
<td><b>Real Name</b></td>
<td><b>Location</b></td>
<td><b>Followers</b></td>
<td><b>Following</b></td>
<td><b>Tweets</b></td>
<td><b>SEND TWEET</b></td>
</tr>
<?php
$count=0;
$c = 0;
foreach(file('./botnet.db') as $bot) {
	if($c == 0) {
		$c = 1;
		$color = '#ffffff';
	} else {
		$c = 0;
		$color = '#0094DE';
	}
	$user = explode(" ", $bot);
	$user = clean($user[0]);
	$okay = get_headers("https://twitter.com/users/show/$user");
	$okay = $okay[0];
	if($okay == "HTTP/1.1 200 OK" | $okay == "HTTP/1.0 200 OK") {
		$xml = file_get_contents("https://twitter.com/users/show/$user");
		$followers = clean(get_value($xml, "<followers_count>", "</followers_count>"));
		$id = clean(get_value($xml, "<id>", "</id>"));
		$username = clean(get_value($xml, "<screen_name>", "</screen_name>"));
		$realname = clean(get_value($xml, "<name>", "</name>"));
		$location = clean(get_value($xml, "<location>", "</location>"));
		$following = clean(get_value($xml, "<friends_count>", "</friends_count>"));
		$member_since = clean(get_value($xml, "<created_at>", "</created_at>"));
		$statuses = clean(get_value($xml, "<statuses_count>", "</statuses_count>"));
		echo "<tr><td style=\"background-color:$color\"><a href=\"http://twitter.com/#!/$username\" target=\"_blank\">$username</a></td>
			<td style=\"background-color:$color\">$id</td>
			<td style=\"background-color:$color\">$member_since</td>
			<td style=\"background-color:$color\">$realname</td>
			<td style=\"background-color:$color\">$location</td>
			<td style=\"background-color:$color\">$followers</td>
			<td style=\"background-color:$color\">$following</td>
			<td style=\"background-color:$color\">$statuses</td>
			<td style=\"background-color:$color\"><form method=\"post\" action=\"./doit.php\"><input type=\"text\" name=\"input_data\" /><input type=\"hidden\" name=\"action\" value=\"singletweet\" /><input type=\"hidden\" name=\"botid\" value=\"$count\" /><input type=\"submit\" value=\"Tweet\" /></form></td></tr>";
	} else {
		echo "<tr><td style=\"background-color:$color\">$user</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td>
			<td style=\"background-color:$color\">ERR</td></tr>";
		}
	$count=$count+1;
}
?>
</table>
