<!-- Listing 9-6: Handler for multidimensional array form -->
<?php

// Exercise types
$exercise_types = array(0 => 'Aerobic exercise',
                        1 => 'Sports',
                        2 => 'Strength training',
                        3 => 'Stretching/flexibility'
                       );

// This is the multidimensional array where we keep our exercises
$exercise_array = 
  array(0 => array(0 => 'Biking/cycling',
                   1 => 'Rowing',
                   2 => 'Running',
                   3 => 'Stairclimber',
                   4 => 'Walking'
                   ),
        1 => array(0 => 'Basketball',
                   1 => 'Ice hockey',
                   2 => 'Soccer/football',
                   3 => 'Table tennis'
                   ),
        2 => array(0 => 'Calisthenics',
                   1 => 'Weightlifting (light)',
                   2 => 'Weightlifting (strenuous)',
                  ),
        3 => array(0 => 'Pilates',
                   1 => 'Tai chi',
                   2 => 'Yoga',
                   )
        );

// This is the array where we keep our duration data
$duration_array = 
  array(0 => array(0 => '5 hours and 40 minutes',
                   1 => '4 hours and 10 minutes',
                   2 => '4 hours and 30 minutes',
                   3 => '5 hours',
                   4 => '10 hours and 10 minutes'
                   ),
        1 => array(0 => '5 hours',
                   1 => '5 hours',
                   2 => '4 hours and 30 minutes',
                   3 => '10 hours and 10 minutes'
                   ),
        2 => array(0 => '6 hours and 30 minutes',
                   1 => '13 hours and 30 minutes',
                   2 => '7 hours and 30 minutes',
                   ),
        3 => array(0 => '8 hours and 45 minutes',
                   1 => '10 hours and 10 minutes',
                   2 => '16 hours',
                   )
        );

// Now step through the exercises and see which one they chose
if (is_array($_POST) && count($_POST) > 1
    && is_array($_POST['exercise'])) {
  $message = '';
  foreach ($_POST['exercise'] as $key_1 => $val) {
    // $val should be an array
    if (!is_array($val)) {
      $message .= "Something's wrong -- value not array<BR>";
    }
    else {
      // Add heading
      $heading = $exercise_types[$key_1];
      $message .= "</P>\n<P><B>$heading</B>";
      foreach ($val as $key_2 => $val_2) {
        if ($val_2 == 1) {
          $exercise_name = $exercise_array[$key_1][$key_2];
          $hours = $duration_array[$key_1][$key_2];
          $message .= "</P>\n<P>It would take $hours of ".
            "$exercise_name to burn one pound of fat.";
        }
      }
    }
  }
} else {
  // Hmmm, they didn't pick one or something wack happened
  $message = 'Ummm, did you pick an exercise?';
} 

// Now lay out the page
// --------------------
$page_str = <<< EOPAGE
<HTML>
<HEAD>
<STYLE TYPE="text/css">
<!--
BODY, P     
{color: black; font-family: verdana; font-size: 10 pt}
H1        
{color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</HEAD>

<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=150>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Workout calculator handler (multidimensional arrays)</H1>
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
