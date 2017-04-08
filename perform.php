<?php
include('./functions.php');
$action = $argv[1];

switch ($action) {

	case 'alltweet':
		//USAGE: action.php alltweet 'message to send'
		//Options
		$message	=	$argv['2'];
		$number_of_bots	=	database_count_bots()-1;
		$sent		=	0; //start with 0.
		//end of Options
		while($sent <= $number_of_bots) {
			bot_tweet($sent, "$message");
			$sent=$sent+1;
			sleep(rand(5, 30));
		}	
	break;

	case 'selecttweet':
		//USAGE: action.php selecttweet botlist 'message to send'
		//Options
		$message	=	$argv['3'];
		$botlist	=	$argv['2'];
		$sent		=	0; //start at 0.
		//End of Options.
		while($sent <= count($botlist)-1) {
			bot_tweet($sent, "$message");
			$sent=$sent+1;
			sleep(rand(5, 30));
		}
	break;

	case 'singletweet':
		//USAGE: singletweet botid 'message to send'
		//Options
		$message	=	$argv['3'];
		$botid		=	$argv['2'];
		//End of Options
		bot_tweet($botid, $message);
	break;

	case 'allfollow':
		//USAGE: action.php allfollow 'userid'
		//Options
		$userid		=	$argv['2'];
		$number_of_bots	=	database_count_bots()-1;
		$sent		=	0; //start with 0.
		//end of Options
		while($sent <= $number_of_bots) {
			bot_follow($sent, $userid);
			$sent=$sent+1;
			sleep(rand(5, 30));
		}	
	break;

/*
	case 'selectfollow':
		//Options
		$account_to_follow	=	$_GET['follow'];
		$botlist		=	$_GET['botid'];
		$sent			=	0; //start at 0.
		//End of Options.
		while($sent <= count($botlist)-1) {
			bot_follow("".$botid[$sent]."", $account_to_follow);
			$sent=$sent+1;
			sleep(rand(5, 30));
		}
	break;

	case 'singlefollow':
		//Options
		$account_to_follow	=	$_GET['follow'];
		$botid			=	$_GET['botid'];
		//End of Options
		bot_follow($botid, $account_to_follow);
	break;
*/
}
echo "\nFinished with request.\n";
?>
