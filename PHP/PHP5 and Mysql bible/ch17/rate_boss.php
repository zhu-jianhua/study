<!-- Listing 17-4: a three-part form (rate_boss.php) -->
<?php

// First set the form strings, which will be displayed
//in various cases below
$thisfile = $_SERVER['PHP_SELF']; //Have to set this for heredoc

$reg_form = <<< EOREGFORM
<P>We must ask for your name and email address to ensure that no one votes more than once, but we do not associate your personal information with your rating.</P>
<FORM METHOD="post" ACTION="$thisfile">
Name: <INPUT TYPE="text" SIZE=25 NAME="name"><BR><BR>
Email: <INPUT TYPE="text" SIZE=25 NAME="email">
<INPUT TYPE="hidden" NAME="stage" VALUE="register">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>
EOREGFORM;

$rate_form = <<< EORATEFORM
<P>My boss is:</P>
<FORM METHOD="post" ACTION="$thisfile">
<INPUT TYPE="radio" NAME="rating" VALUE=1> Driving me to look for a new job.<BR>
<INPUT TYPE="radio" NAME="rating" VALUE=2> Not the worst, but pretty bad.<BR>
<INPUT TYPE="radio" NAME="rating" VALUE=3> Just so-so.<BR>
<INPUT TYPE="radio" NAME="rating" VALUE=4> Pretty good.<BR>
<INPUT TYPE="radio" NAME="rating" VALUE=5> A pleasure to work with.<BR><BR>
Boss's name: <INPUT TYPE="text" SIZE=25 NAME="boss"><BR>
<INPUT TYPE="hidden" NAME="stage" VALUE="rate">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>
EORATEFORM;

if (!$_POST['submit']) {
  // First time, just show the registration form
  $message = $reg_form;

} elseif ($_POST['submit'] == 'Submit' && $_POST['stage'] == 'register') {
  // Second time, show the registration form again on error,
  // rating form on successful INSERT
  if (!$_POST['name'] || $_POST['name'] == "" || strlen($_POST['name'] > 30) || !$_POST['email'] || $_POST['email'] == "" || strlen($_POST['email'] > 30)) {
    $message = '<P>There is a problem.  Did you enter a name and email address?</P>';
    $message .= $reg_form;
  } else {
    // Open connection to the database
    mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
    mysql_select_db("test");

    // Check to see this name and email have not appeared before
    $as_name = addslashes($_POST['name']);
    $tr_name = trim($as_name);
    $as_email = addslashes($_POST['email']);
    $tr_email = trim($as_email);
    $query = "SELECT sub_id FROM raters
              WHERE Name = '$tr_name'
              AND Email = '$tr_email'
             ";
    $result = mysql_query($query);
    if (mysql_num_rows($result) > 0) {
      error_log(mysql_error());
      $message = 'Someone with this name and password has already rated .  If you think a mistake was made, please email help@example.com.';
    } else {
      // Insert name and email address
      $query = "INSERT INTO raters (ID, Name, Email)
                VALUES(NULL, '$tr_name', '$tr_email')
               ";
      $result = mysql_query($query);
      if (mysql_affected_rows() == 1) {
        $message = $rate_form;
      } else {
        error_log(mysql_error());
        $message = '<P>Something went wrong with your signup attempt.</P>';
        $message .= $reg_form;
      }
    }
  }

}  elseif ($_POST['submit'] == 'Submit' && $_POST['stage'] == 'rate') {
  // Third time, store the rating and boss's name

  // Open connection to the database
  mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
  mysql_select_db("test");

  // Insert rating and boss's name
  $as_boss = addslashes($_POST['boss']);
  $tr_boss = trim($as_boss);
  $rating = $_POST['rating'];
  $query = "INSERT INTO ratings (ID, Rating, Boss)
            VALUES(NULL, '$rating', '$tr_boss')
           ";
  $result = mysql_query($query);
  if (mysql_affected_rows() == 1) {
    $message = '<P>Your rating has been submitted.</P>';
  } else {
    error_log(mysql_error());
    $message = '<P>Something went wrong with your rating attempt.  Try again.</P>';
    $message .= $rate_form;
  }
}
?>

<HTML>
<HEAD>
<STYLE TYPE="text/css">
<!--
BODY, P      {color: black; font-family: verdana; font-size: 10 pt}
H1        {color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</HEAD>

<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Rate your boss anonymously</H1>
<?php echo $message; ?>
</TD>
</TR>
</TABLE>

</BODY>
</HTML>
