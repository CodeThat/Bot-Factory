<?php
require_once('./twitteroauth.php');

function strclean($string) {
        $return = str_replace("\n", "", $string);
        $return = str_replace("\r", "", $return);
        $return = str_replace("&lt;", "<", $return);
        $return = str_replace("&gt;", ">", $return);
        $return = str_replace("&amp;", "&", $return);
        $return = str_replace("&quote;", "\"", $return);
        return $return;
}

function get_value($string, $start, $end) {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
}

function clean($string) { return str_replace("\n", "", str_replace("\r", "", $string)); }

function tweet($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret, $message) {
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
	return var_dump($tweet->post('statuses/update', array('status' => "$message")));
}

function database_count_bots() { return count(file('./botnet.db')); }

function database_read_bot($userid) {
	$database_array = file('./botnet.db');
	if(!$database_array[$userid]) { return "BAD/404"; } else { return explode(" ", $database_array[$userid]); }
}

function bot_tweet($id, $message) {
	if(database_read_bot($id) == "BAD/404") { return "BAD/400"; } else {
		$botinfo 	=	database_read_bot($id);
		$ckey		=	$botinfo[1];
		$csecret	=	$botinfo[2];
		$atoken		=	$botinfo[3];
		$asecret	=	$botinfo[4];
		return tweet(clean($ckey), clean($csecret), clean($atoken), clean($asecret), clean($message));
	}
}

function follow($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret, $user_id) {
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
	return var_dump($tweet->post('friendships/create', array('user_id' => "$user_id")));
}

function bot_follow($id, $user_id) {
	if(database_read_bot($id) == "BAD/404") { return "BAD/400"; } else {
		$botinfo 	=	database_read_bot($id);
		$ckey		=	$botinfo[1];
		$csecret	=	$botinfo[2];
		$atoken		=	$botinfo[3];
		$asecret	=	$botinfo[4];
		if(!is_numeric($user_id)) {
			$okay = get_headers("https://twitter.com/users/show/$user_id");
			$okay = $okay[0];
			if($okay == "HTTP/1.1 200 OK" | $okay == "HTTP/1.0 200 OK") {
				$xml = file_get_contents("https://twitter.com/users/show/$user_id");
				$user_id = clean(get_value($xml, "<id>", "</id>"));
			} else {
				die("User could not be found!");
			}
		}
		return follow(clean($ckey), clean($csecret), clean($atoken), clean($asecret), clean($user_id));
	}
}

?>
