<!-- Listing 9-4: Exercise Calculator - Handler for check boxes -->
<?php

// This is the array where we keep our exercise names
$name_array = array(
                    0 => 'Biking/cycling',
                    1 => 'Running',
                    2 => 'Soccer/football',
                    3 => 'Stairclimber',
                    4 => 'Weightlifting'
                  );

// This is the array where we keep our duration data
$duration_array = array(
                    0 => '5 hours and 40 minutes',
                    1 => '4 hours and 30 minutes',
                    2 => '4 hours and 30 minutes',
                    3 => '5 hours',
                    4 => '7 hours and 30 minutes'
                  );

// Now step through the exercises and see which ones they chose
if (is_array($_POST) && count($_POST) > 1) {
  $message = '';
  foreach ($_POST['exercise'] as $key => $val) {
    if ($val == 1) {
      $exercise_name = $name_array[$key];
      $hours = $duration_array[$key];
      $message .= 
        "</P>\n<P>It would take $hours of $exercise_name " .
	     "to burn one pound of fat.";
    }
  }
}
else {
  // Hmmm, they didn't pick one or something strange happened
  $message = 'Ummm, did you pick an exercise?';
} //If you don't have this test, an empty form will cause an error.
  //Usually you'd test an array for a count of 0, but here 
  //there is 1 automatic POST array element -- $_POST['submit'].


// Now lay out the page
// --------------------
$page_str = <<< EOPAGE
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
<TABLE BORDER=0 CELLPADDING=10 WIDTH="100%">
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=150>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH="83%">
<H1>Workout calculator handler (multiple checkboxes with arrays)</H1>
<P>The workout calculator says:
$message</P>
</TD>
</TR>
</TABLE>

</BODY>
</HTML>
EOPAGE;

echo $page_str;

?>


