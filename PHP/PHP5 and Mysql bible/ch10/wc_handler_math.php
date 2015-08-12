<!-- Listing 10-3: Handler code for the fitness calculator (wc_handler_math.php) -->
<?php
include_once("exercise_include.php");
$weight = $_POST["weight"];

// scale linearly assuming 65-kilo norm
$weight_factor = $weight / 65.0;  

$exercise_accumulator = array();
$type_counter = 0;
if (is_array($_POST) && count($_POST) > 1
    && is_array($_POST['exercise'])) {
  foreach ($exercise_info 
             as $exercise_type => $per_exercise_info) {
    $exercise_counter = 0;
    foreach ($per_exercise_info 
      as $exercise_name => $exercise_intensity) {
      $minutes = 
        $_POST['exercise'][$type_counter][$exercise_counter];
      if ($minutes > 0) {
        $exercise_accumulator[$exercise_type][$exercise_name]
          = round($minutes * $exercise_intensity * 
                  $weight_factor);
      }
    $exercise_counter++;
  }
  $type_counter++;
  }
}

// now we use $exercise_accumulator to build a display string
$total_calories = 0;
$message = "";
foreach ($exercise_accumulator
           as $exercise_type => $per_exercise_info) {
  $message .= "<P><B>$exercise_type</B></P>";
  foreach ($per_exercise_info 
    as $exercise_name => $calories_burned) {
      $message .= "<P>".
          ucfirst("$exercise_name: $calories_burned calories</P>");
      $total_calories += $calories_burned;
  }
}
if ($message == "" || $weight == 0) {
   $message =
     "<P>Did you enter your weight and at least one exercise?";
}
else {
   $message .= 
     "<P><B>Total calories burned: $total_calories</B></P>";
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
<TABLE BORDER=0 CELLPADDING=10 WIDTH="100%">
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=150>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH="83%">
<H1>Workout calculator handler (Math)</H1>
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
