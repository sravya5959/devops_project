<?php
STATIC $num_users_logged_in =0;
$count++;
$date = new DateTime();
$myfile = fopen("log.log", "a") or die("Unable to open file!");
$log = $count."  ".$date->getTimestamp()."		";
fwrite($myfile,$log);
fclose($myfile);
?>