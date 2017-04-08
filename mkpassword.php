<?php
if(!$_POST[mkpasswd]) {
echo "<form action='./mkpasswd.php' method='post'>
<input type='password' name='mkpasswd' id='mkpasswd' /> <input type='submit' value='mkpasswd' />
</form>"; } else {
$passwd = str_replace("\n", "", $_POST['mkpasswd']);
$passwd = str_replace("\r", "", $passwd);
echo md5($passwd);
}
?>
