<!-- Listing 37-3: mailinglist.php -->
<html>
<head>
<title>ThrillerGuide: Site update notification</title>
</head>
<body>
<?php
mysql_connect('localhost', 'root');
mysql_select_db('thrillerguide');

$query = "SELECT email FROM mailinglist";
$result = mysql_query($query);
while ($MailArray = mysql_fetch_array($result)) {
  $formsent = mail($MailArray[0], "2000.1.23 ThrillerGuide update", "This is to inform you that ThrillerGuide has recently been updated.\r\n\r\nYou requested these e-mail notifications. If you do not wish to receive them, reply to this mail with \"Cancel\" in the subject line.", "From: mailinglist@thrillerguide.com\r\nReply-to: help@example.com");
  echo "The result is $formsent.\n";
}
?>
</body>
</html>
