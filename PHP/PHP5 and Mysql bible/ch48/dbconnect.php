<?php
$user = 'tworks';
$pass = 'sasquatch';
$db = 'venn';
$link = mysql_connect('localhost', $user, $pass) 
  or die("Could not connect " . mysql_error());
mysql_select_db($db);
?>
