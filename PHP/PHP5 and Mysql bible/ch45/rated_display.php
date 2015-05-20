<?php
include_once("db_connection.php");
include_once("rating_functions.php");
include_once("content_functions.php");

if (isSet($_GET['RATED_ID'])) {
  $rated_id = $_GET['RATED_ID'];
}
else if (isSet($_POST['RATED_ID'])) {
  $rated_id = $_POST['RATED_ID'];
}
else {
  $rated_id = 1;
}

// create the quote content
$content_box = 
  make_content_box($_SERVER['PHP_SELF'],
                   $rated_id);

// create the navigation links
$nav_box = 
  make_next_prev_box($_SERVER['PHP_SELF'],
                     $rated_id);

// create the self-submitting ratings box
// (also handles submissions)
$submission_box = 
  make_ratings_box($_SERVER['PHP_SELF'],
                   $rated_id);

// create the link to the main ratings page
$ratings_link = 
  "<A HREF=\"all_ratings.php\">See 
   other ratings</A>";

// create the actual page
$page_string = <<<EOP
<HTML><HEAD><TITLE>Sample ratable page</TITLE></HEAD>
<BODY>
<CENTER><H2>Quote of the moment</H2></CENTER>
<TABLE WIDTH=500 VALIGN=TOP CELLPADDING=20>
<TR VALIGN=TOP>
<TD VALIGN=TOP COLSPAN=50%>
$content_box
<CENTER>$nav_box</CENTER>
</TD><TD ALIGN=TOP COLSPAN=50%>
$submission_box
<BR>$ratings_link
</TD></TR></TABLE>
</BODY></HTML>
EOP;
echo $page_string;
?>
