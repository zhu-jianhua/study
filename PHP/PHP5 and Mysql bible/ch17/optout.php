<!-- Listing 17-6: checkbox displaying boolean data from database (optout.php) -->
<?php

// Open connection to the database
mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
mysql_select_db("test");

// If the form has been submitted, record the preference and redisplay
if ($_POST['submit'] == 'Submit') {
  $email = $_POST['email'];
  $as_email = addslashes($_POST['email']);
  if (isSet($_POST['OptOut'] && $_POST['OptOut'] == 1) {
    $optout = 1;
  } else {
    $optout = 0;
  }

  // Update value
  $query = "UPDATE checkbox
            SET BoxValue = $optout
            WHERE BoxName = 'OptOut'
            AND email = '$as_email'";
  $result = mysql_query($query);
  if (mysql_error() == "") {
    $success_msg = '<P>Your preference has been updated.</P>';
  } else {
    error_log(mysql_error());
    $success_msg = '<P>Something went wrong.</P>';
  }
  // Get the value
  $query = "SELECT BoxValue FROM checkbox WHERE BoxName = 'OptOut' AND email = '$as_email'";
  $result = mysql_query($query);
  $optout = mysql_result($result, 0, 0);

  if ($optout == 0) {

    $checked = "";
  } elseif ($optout == 1) {
    $checked = 'CHECKED';
  }
}


// Now display the page
$thispage = $_SERVER['PHP_SELF']; //Have to do this for heredoc

$form_page = <<< EOFORMPAGE
<HTML>
<HEAD>
<TITLE>Semi-sleazy opt-in form</TITLE>
</HEAD>

<BODY>
$success_msg
<FORM METHOD=POST ACTION="$thispage">
Email address:  <INPUT TYPE="text" NAME="email" SIZE=25 VALUE="$email"><BR><BR>
<FONT SIZE=+4>Please send me lots of e-mail bulletins!</FONT><BR>
<FONT SIZE=-2>opt out by clicking this tiny checkbox</FONT>
<INPUT TYPE="checkbox"  NAME="OptOut" VALUE=1 $checked><BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>

</BODY>
</HTML>
EOFORMPAGE;
echo $form_page;

?>

