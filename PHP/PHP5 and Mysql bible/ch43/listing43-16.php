<?php

/************************************************************
 * This page has 4 possible cases:                          *
 * 1.  You're viewing this page without a supplied date,    *
 * so default to Case 4.                                    *
 *                                                          *
 * 2.  There is a date.  This is neither the first nor      *
 * the last entry in the db.                                *
 *                                                          *
 * 3.  There is a date.  This is the first entry in the db. *
 *                                                          *
 * 4.  There is a date.  This is the last entry in the db.  *
 ************************************************************/
      
// Open database connection
include("/home/htmluser/db_password.inc");
mysql_connect($hostname, $user, $password);
mysql_select_db("weblogs");

// Identify the latest entry
$query = "SELECT MAX(ID) FROM mylog";
$result = mysql_query($query);
$lastID_row = mysql_fetch_array($result);
$last_ID = $lastID_row[0];

// Get specified weblog entry
if ($_GET['date'] != "") {
  $entry_date = $_GET['date'];
  $query1 = "SELECT * FROM mylog WHERE date = $entry_date";
} else {
  $query1 = "SELECT * FROM mylog WHERE ID = $last_ID";
}
$result1 = mysql_query($query1);
$row_test_num = mysql_num_rows($result1);
if ($row_test_num > 0) {
  $entry_row = mysql_fetch_array($result1);
  $entry_ID = $entry_row[0];
  $entry_date = $entry_row[1];
  $entry = stripslashes($entry_row[2]);
} else {
  // If someone enters a bad date, redirect to homepage
  header("Location: /index.php");
}

// Get previous date for Cases 2 and 4
if ($entry_ID > 1) {
  $prev_ID = $entry_ID - 1;
  $query2 = "SELECT date FROM mylog WHERE ID = $prev_ID";
  $result2 = mysql_query($query2);
  $prevdate_row = mysql_fetch_array($result2);
  $prev_date = $prevdate_row[0];
} else {
  $prev_date = "";
}

// Get next date for Cases 2 and 3
if ($entry_ID != $last_ID) {
  $next_ID = $entry_ID + 1;
  $query3 = "SELECT date FROM mylog WHERE ID = $next_ID";
  $result3 = mysql_query($query3);
  $nextdate_row = mysql_fetch_array($result3);
  $next_date = $nextdate_row[0];
} else {
  $next_date = "";
}

// Assemble the Previous/Next links
// Case 2
if ($next_date != "" && $prev_date != "") {
  $flipbar = "\n<TABLE BORDER=0><TR>
<TD WIDTH=\"50%\" ALIGN=\"left\">
<SPAN CLASS=\"previous\">
<A HREF=\"$PHP_SELF?date=$prev_date\">&#60;-- Previous</A>
</SPAN>
</TD><TD WIDTH=\"50%\" ALIGN=\"right\">
<SPAN CLASS=\"next\">
<A HREF=\"$PHP_SELF?date=$next_date\">Next --&#62;</A>
</SPAN>
</TD></TR></TABLE>\n";
}
// Case 3
elseif ($next_date != "" && $prev_date == "") {
  $flipbar = "\n<P CLASS=\"next\">
<A HREF=\"$PHP_SELF?date=$next_date\">Next --&#62;</A>
</P>\n";
}
// Case 4
elseif($next_date == "" && $prev_date != "") {
  $flipbar = "\n<P CLASS=\"previous\">
<A HREF=\"$PHP_SELF?date=$prev_date\">&#60;-- Previous</A>
</P>\n";
}


// ---------------------
// NOW ASSEMBLE THE PAGE
// ---------------------
$title_msg = $entry_date;
$header_msg = "Weblog entry for $entry_date";
include_once('header.inc');

echo $flipbar;
// Include the specified entry text
echo $entry;
echo $flipbar;

include_once('footer.inc');
?>