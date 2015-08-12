<?php
include("/home/htmluser/db_password.inc");
mysql_connect($hostname, $user, $password);
mysql_select_db("weblogs");

// Validate this user
$test_username = $_POST['test_username'];
$query = "SELECT password
          FROM login
          WHERE username = '$test_username'";
$result = mysql_query($query);
if (mysql_num_rows($result) != 1) {
  echo "Something is wrong";
  exit;
}
$password_row = mysql_fetch_array($result);
$db_password = $password_row[0];

if ($_POST['test_password'] == $db_password &&
$_POST['test_password'] != "") {
  if ($_POST['Submit'] == 'Enter') {
    // Enter new entry
    $date = date('Ymd'); // Remember, date is an integer type
    $blogtext = $_POST['blogtext'];
    $query = "INSERT INTO mylog (ID, date, blogtext)
VALUES(NULL, $date, '$blogtext')";
    $result = mysql_query($query);
    if (mysql_affected_rows() == 1) {
      header("Location: db_login.php");
    } else {
      echo "There was a problem inserting your text.";
      exit;
    }
  } else {
    // Show the form
    $php_self = $_SERVER['PHP_SELF'];
    $test_password = $_POST['test_password'];
$form_str = <<< EOFORMSTR
<HTML>
<HEAD>
<TITLE>Weblog data entry screen</TITLE>
</HEAD>
<BODY>
<FORM ACTION="$php_self" METHOD="POST">
<P>Text:<BR>
<TEXTAREA NAME="blogtext" COLS=75 ROWS=20
WRAP="VIRTUAL"></TEXTAREA></P>
<INPUT TYPE="hidden" NAME="test_username"
VALUE="$test_username">
<INPUT TYPE="hidden" NAME="test_password"
VALUE="$test_password">
<P><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="Enter"></P>
</FORM>
</BODY>
</HTML>
EOFORMSTR;
    echo $form_str;
  }
} else {
  mail("me@localhost", "Weblog snoop", "Someone from
$REMOTE_ADDR is trying to get into your weblog entry screen.");
}
?>