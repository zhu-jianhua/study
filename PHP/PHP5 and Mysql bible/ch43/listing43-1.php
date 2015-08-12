<?php

// -------------------------------
// GET YOUR VARIABLES ALL LINED UP
// -------------------------------
// Change this to the date of your first log entry.
$initial_entry_date = 20040101;

// Replace the fake path below with a real one
$DOCUMENT_ROOT = "c:\docs";

$today = date('Ymd');
if (isSet($_GET['date'])) {
  if ($_GET['date'] < $initial_entry_date) {
    // Go to first entry if the specified date is earlier 
    // than range
    $date = $initial_entry_date;
  } elseif ($_GET['date'] > $today) {
    // Go to last entry if specified date is later than range
    $date = $today;
  } else {
    $date = $_GET['date'];
  }
} else {
  $date = $today;
}
$title_msg = $date;
$header_msg = "Weblog entry for $date";

// Assemble the Previous/Next links
$prevdate = $date - 1;
$nextdate = $date + 1;
if ($date == $initial_entry_date) {
  $flipbar = "\n<P CLASS=\"next\">
<A HREF=\"$PHP_SELF?date=$nextdate\">Next --&#62;</A>
</P>\n";
} elseif ($date == $today) {
  $flipbar = "\n<P CLASS=\"previous\">
<A HREF=\"$PHP_SELF?date=$prevdate\">&#60;-- Previous</A>
</P>\n";
} else {
  $flipbar = "\n<TABLE BORDER=0><TR>
<TD WIDTH=\"50%\" ALIGN=\"left\">
<SPAN CLASS=\"previous\">
<A HREF=\"$PHP_SELF?date=$prevdate\">&#60;-- Previous</A>
</SPAN>
</TD><TD WIDTH=\"50%\" ALIGN=\"right\">
<SPAN CLASS=\"next\">
<A HREF=\"$PHP_SELF?date=$nextdate\">Next --&#62;</A>
</SPAN>
</TD>
</TR></TABLE>\n";
}



// ---------------------
// NOW ASSEMBLE THE PAGE
// ---------------------
include_once('header.inc');

echo $flipbar;
// Include the specified text file, or a default message
// Replace the fake path below with a real one
if (file_exists($DOCUMENT_ROOT."/path/to/entries/$date.txt")) {
  // Replace the fake path below with a real one
  include($DOCUMENT_ROOT."/path/to/entries/$date.txt");
} else {
  include("default.txt");
}
echo $flipbar;

include_once('footer.inc');
?>