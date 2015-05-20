<!-- Listing 8-2: Exercise Calculator - Form handler using string functions -->
<?php$exercise = $_POST['exercise']; // NOTE: only works in PHP 4.1+
// Make sure they aren't trying to do naughty things
if (strlen($exercise) > 50) {
  echo "You aren't playing by the rules.  Bad dog!";
  exit;
}
// Try to parse the input string
// -----------------------------
// Make sure there aren't any spaces before or after
$exercise = trim($exercise);

// Convert to all lowercase for better string matching
$exercise = strtolower($exercise);

// Try to standardize on gerund form, if possible
if (strpos($exercise, 'ing') > 0) {
  // Already good
  $exercise_str = $exercise;
} elseif ($exercise == 'bike' || $exercise == 'cycle') {
  $exercise_str = 'cycling';
} elseif ($exercise == 'run' || $exercise == 'jog') {
  $exercise_str = 'running';
} elseif ($exercise == 'soccer' || $exercise == 'football') {
  $exercise_str = 'soccer';
} elseif (strstr($exercise, 'weight') || strstr($exercise, 'strength')) {
  $exercise_str = 'weight lifting';
}


// Now assign a number of hours to burn one pound of fat to each sport
if ($exercise_str == 'cycling' || $exercise_str == 'biking') {
  $hours = '5 hours and 40 minutes';
} elseif ($exercise_str == 'running' || $exercise_str == 'jogging') {
  $hours = '4 hours and 30 minutes';
} elseif ($exercise_str == 'soccer' || $exercise_str == 'football') {
  $hours = '4 hours and 30 minutes';
} elseif ($exercise_str == 'weight lifting') {
  $hours = '7 hours and 30 minutes';
} else {
  // Nullify all other exercises
  $exercise_str = '';
  $hours = '';
}

// Construct a sentence
// --------------------

if ($exercise_str != "" && $hours != "") {
  $message = 'It would take '.$hours.' of '.$exercise_str.' to burn one pound of fat.';
} elseif ($exercise_str == "" && $hours == "") {
  // If the exercise isn't in the list above, give a 
  // default message.
  $message = 'Sorry, we do not have data for that exercise.';
} else {

  // There are two other logical possibilities 
  // 1.  We recognize the exercise but don't have a duration   
  // for it 
  // 2.  We don't recognize the exercise but somehow have a 
  // duration 
  // neither should happen, but just in case...
  $message = 'Something has gone horribly wrong!'; 
}
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
<H1>Workout calculator handler, part 2</H1>
<P>The workout calculator says, "$message"</P>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
EOPAGE;

echo $page_str;

?>



