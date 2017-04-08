<?php
$username="admin";
$passwdhash="21232f297a57a5a743894a0e4a801fc3";
if(str_replace("\r", "", str_replace("\n", "", "".$_POST['username'].":".md5($_POST['password'])."")) == "$username:$passwdhash") {
        session_start();
        $_SESSION['is_logged_in'] = "OK/200";
}
        header("Location: ./index.php");
?>

