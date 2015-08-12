<!-- Listing 17-3: unified form and form-handler (newsletter_signup.php) -->
<?php

if ($_POST['submit'] == 'Submit') {
  if (!$_POST['email'] || $_POST['email'] == "" || strlen($_POST['email'] > 30)) {
    $message = '<P>There is a problem.  Did you enter an email address?</P>';
  } else {
    // Open connection to the database
    mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
    mysql_select_db("test");

    // Insert email address
    $as_email = addslashes($_POST['email']);
    $tr_email = trim($as_email);
    $query = "INSERT INTO mailinglist (ID, Email, Source)
              VALUES(NULL, '$tr_email', 'www.example.com/newsletter_signup.html')
             ";
    $result = mysql_query($query);
    if (mysql_affected_rows() == 1) {
      $message = '<P>Your information has been recorded.</P>';

      $noform_var = 1;
    } else {
      error_log(mysql_error());
      $message = '<P>Something went wrong with your signup attempt.</P>';
    }
  }

  // Show the form in every case except successful submission
  if (!$noform_var) {
    $thisfile = $_SERVER['PHP_SELF'];
    $message .= <<< EOMSG
<P>Enter your email address and we will send you our weekly newsletter.</P>
<FORM METHOD="post" ACTION="$thisfile">
<INPUT TYPE="text" SIZE=25 NAME="email">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>
EOMSG;
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
<H1>Newsletter sign-up form</H1>
<?php echo $message; ?>
</TD>
</TR>
</TABLE>

</BODY>
</HTML>


