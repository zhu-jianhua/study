<?php

function array_to_bar_graph ($array, $max_width) {
  // expects as input an array where the keys
  //    are string labels and the values are
  //    numbers.  Values must be non-negative
  // returns an HTML bar graph as a string
  // assumes bar[1-5].gif, located in images/
  
  foreach ($array as $value) {
    if ((IsSet($max_value) && 
         ($value > $max_value)) ||
        (!IsSet($max_value))) {
      $max_value = $value;
    }
  }
  $pixels_per_value = ((double) $max_width)
                       / $max_value;
                  
  $string_to_return = "<TABLE CELLPADDING=5>";
  $counter = 0;
  foreach ($array as $name => $value) {
    $bar_width = $value * $pixels_per_value;
    $image_no = ($counter % 5) + 1;
    $string_to_return .= 
     "<TR><TD>$name ($value)</TD>
      <TD><IMG SRC=\"images/bar$image_no.gif\"
               WIDTH=$bar_width
               HEIGHT=10>
      </TD></TR>";
    $counter++;
  }
  $string_to_return .= "</TABLE>";
  return($string_to_return);
}
?>
