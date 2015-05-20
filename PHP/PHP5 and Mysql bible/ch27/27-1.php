<!-- Listing 27-1: Displaying trigonometric function results -->
<?php

function display_func_results($func_array, $input_array)
{
/* print a function header */
print("<TABLE BORDER=1><TR><TH>INPUT\\FUNCTION</TH>");
for($y = 0;
        $y < count($func_array);
        $y++)
    print("<TH>$func_array[$y]</TH>");
print("</TR><TR>");
/* print the rest of the table */
for($x = 0;
    $x < count($input_array);
    $x++)
  {
    /* print column entries for inputs */
    print("<TH>".
          sprintf("%.4f", $input_array[$x])
          ."</TH>");
    for($y = 0;
        $y < count($func_array);
        $y++)
    {
      $func_name = $func_array[$y];
      $input = $input_array[$x];
      print("<TD>");
      printf("%4.4f", $func_name($input));
      print("</TD>");
    }
    print("</TR><TR>");
  }
print("</TR></TABLE>");
}
?>

<HTML>
<HEAD>
<TITLE>Trigonometric Function Examples</TITLE>
</HEAD>
<BODY>

<?php
/* using the function displayer */
print("<H3>Trigonometric function examples</H3>");
display_func_results(array("sin", "cos", "tan"),
                     array(-1.25 * pi(),  
                           -1.0 * pi(),  
                           -0.75 * pi(),  
                           -0.5 * pi(),  
                           -0.25 * pi(),
                            0,
                            0.25 * pi(),
                            0.5 * pi(),
                            0.75 * pi(),  
                            pi(),
                            1.25 * pi()));

?>
</BODY>
</HTML>
