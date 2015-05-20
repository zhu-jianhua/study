<!-- Listing 17-2: form handler for newsletter_signup.html (formhandler.php) -->
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
<?php
if (!$_POST['email'] || $_POST['email'] == "" || strlen($_POST['email']) > 30) {
  echo '<P>There is a problem.  Did you enter an email address?</P>';
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
    echo '<P>Your information has been recorded.</P>';
  } else {
    error_log(mysql_error());
    echo '<P>Something went wrong with your signup attempt.</P>';
  }
}
?>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>

