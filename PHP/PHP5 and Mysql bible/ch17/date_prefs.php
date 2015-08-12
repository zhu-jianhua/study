<!-- Listing 17-7: radio buttons displaying boolean data from database (date_prefs.php) -->
<?php

// Subscriber ID is stored in a cookie on the user's browser
$sub_id = $_COOKIE['userID'];

// Open connection to the database
mysql_connect("localhost", "mysqluser", "sesame") or die("Failure to communicate with database");
mysql_select_db("test");

// If the form has been submitted, record the preferences
if ($_POST['submit'] == 'Submit') {
  $height = $_POST['height'];
  $haircolor = $_POST['haircolor'];
  $edu = $_POST['edu'];
  // Update value
  $query = "UPDATE qualities
            SET height = $height, haircolor = $haircolor, edu = $edu
            WHERE subscriber = $sub_id";
  $result = mysql_query($query);
  if (mysql_affected_rows() == 1) {
    $success_msg = '<P>Your preferences have been updated.</P>';
  } else {
    error_log(mysql_error());
    $success_msg = '<P>Something went wrong.</P>';
  }

}

// Get the values
$query = "SELECT height, haircolor, edu FROM qualities WHERE subscriber = $sub_id";
$result = mysql_query($query);
$pref_arr = mysql_fetch_array($result);
$height = $pref_arr[0];
$haircolor = $pref_arr[1];
$edu = $pref_arr[2];

// Assemble the radio button part of the form
if ($height == 1) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=1 checked> Short<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=1> Short<BR>\n";
}
if ($height == 2) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=2 checked> Average height<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=2> Average height<BR>\n";
}
if ($height == 3) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=3 checked> Tall<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=3> Tall<BR>\n";
}
if ($height == 0) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=0 checked> Doesn't matter<BR><BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"height\" VALUE=0> Doesn't matter<BR><BR>\n";
}

if ($haircolor == 1) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=1 checked> Blonde<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=1> Blonde<BR>\n";
}
if ($haircolor == 2) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=2 checked> Brunette<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=2> Brunette<BR>\n";
}
if ($haircolor == 3) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=3 checked> Redhead<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=3> Redhead<BR>\n";
}
if ($haircolor == 0) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=0 checked> Doesn't matter<BR><BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"haircolor\" VALUE=0> Doesn't matter<BR><BR>\n";
}

if ($edu == 1) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=1 checked> High school graduate<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=1> High school graduate<BR>\n";
}
if ($edu == 2) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=2 checked> College graduate<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=2> College graduate<BR>\n";
}
if ($edu == 3) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=3 checked> Advanced degree holder<BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=3> Advanced degree holder<BR>\n";
}
if ($edu == 0) {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=0 checked> Doesn't matter<BR><BR>\n";
} else {
  $radio_str .= "<INPUT TYPE=RADIO NAME=\"edu\" VALUE=0> Doesn't matter<BR><BR>\n";
}


// Now display the page
$thispage = $_SERVER['PHP_SELF']; //Have to do this for heredoc

$form_page = <<< EOFORMPAGE
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
<H1>Dating service</H1>
$success_msg
<P>I am looking for a girl who is:</P>
<FORM METHOD=POST ACTION="$thispage">
$radio_str
<INPUT TYPE=SUBMIT NAME="submit" VALUE="Submit">
</FORM>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
EOFORMPAGE;
echo $form_page;

?>
