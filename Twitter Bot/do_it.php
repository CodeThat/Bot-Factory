<?php
$action = $_POST['action'];
$botid = $_POST['botid'];
$input_data = $_POST['input_data'];

switch($action) {

	case 'alltweet':
		exec("/usr/bin/screen -dmS doit /usr/bin/php ./perform.php alltweet '$input_data'");
		foreach($exec as $dump) {
			echo "$dump\n";
		}
	break;

	case 'singletweet':
		exec("/usr/bin/php ./perform.php singletweet $botid '$input_data'", $exec);
		foreach($exec as $dump) {
			echo "$dump\n";
		}
	break;

	case 'allfollow':
		exec("/usr/bin/screen -dmS doit /usr/bin/php ./perform.php allfollow '$input_data'", $exec);
		foreach($exec as $dump) {
			echo "$dump\n";
		}
	break;

}

header("Location: ./index.php");

?>
