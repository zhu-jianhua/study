<!-- Listing 37-6: Batch e-mail form handler (email_send.php) -->
<html>
<head>
<title>email_send.php</title>
</head>

<body>
<?php
/* This screen enters the names, addresses, and passwords into a database and sends the e-mails off into the wild black yonder of cyberspace. */

include("password_maker.inc");

mysql_connect('localhost', 'root');
mysql_select_db('mailinglist');

$list_length = 0;
// Includes a test to stop the loop sooner if
// fewer than 25 names have been entered.
for ($list_length = 0 && strlen($_POST['Email'][$list_length] > 0; $list_length <= 24 && strlen($_POST['Email'][$list_length]) > 0; $list_length++) {
  // 8 is the number of characters desired in each password.
  $Password = random_string($charset, 8);
  $FirstName = $_POST['FirstName'][$list_length];
  $LastName = $_POST['LastName'][$list_length];
  $Email = $_POST['Email'][$list_length];
  $query = "INSERT INTO recipient (FirstName, LastName, Email, Password) VALUES('$FirstName', '$LastName', '$Email', $Password)";
  $result = mysql_query($query);
  $formsent = mail($Email, "Login and password info", "Your login is: $FirstName $LastName.\r\nMake sure there is only one space between the two words when you log in.\r\nYour password is: $Password.\nGood luck!", "From: mailinglist@sendhost\r\nReply-to: help@sendhost");
  echo "The result is $formsent for $list_length.<BR>\n";
}

?>
</body>
</html>

