<!-- Listing 37-2: titlehelp.php -->
<html>
<head>
<title>titlehelp.php</title>
</head>

<body>
<?php
// If you wished, you could also save this information to a database
$LastName = $_POST['LastName'];
$FirstName = $_POST['FirstName'];
$Year = $_POST['Year'];
$Setting = $_POST['Setting'];
$Gender = $_POST['Gender'];
$Status = $_POST['Status'];
$Other = $_POST['Other'];

$formsent = mail('help@example.com', 'What was the name of that thriller?', "Request from: $LastName $FirstName\r\nYear: $Year\r\nSetting(s): $Setting\r\nProtagonist gender: $Gender\r\nBook status: $Status\r\nOther identifying characteristics: $Other", "From: $Email\r\nBounce-to: help@example.com");
if ($formsent) {
  echo "<P>Hi, $FirstName.  We have received your request for help, and will try to respond within 24 hours.  Thanks for visiting ThrillerGuide.com!";
} else (
  echo "I'm sorry, there's a problem with your form.  Please try again.";
)
?>
</body>
</html>




