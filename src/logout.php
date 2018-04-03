<?php
session_destroy();
echo"<script> window.location.href = 'login.html' ; </script>";	
exit();
	//Me mashing my keyboard, aka uncrackable password.
	//Don't want to accidentally leave this lying around unsecure.
/*set_include_path('phpseclib');
include('Net/SSH2.php');
$ip=$_SESSION['ip'];
$uname=$_SESSION['uname'];
$pass=$_SESSION['pass'];
$password = $pass;


$ssh = new Net_SSH2($ip);
*/
?>