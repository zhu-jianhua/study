<!-- Listing 25-1: Type conversions -->
<?php
$type_examples[0] = 123; // an integer
$type_examples[1] = 3.14159; // a double
$type_examples[2] = "a non-numeric string";
$type_examples[3] = "49.990 (begins with number)";
$type_examples[4] = array(90,80,70);

print("<TABLE BORDER=1><TR>");
print("<TH>Original</<TH>");
print("<TH>(int)</<TH>");
print("<TH>(double)</<TH>");
print("<TH>(string)</<TH>");
print("<TH>(array)</<TH></TR>");

for ($index = 0; $index < 5; $index++)
  {
    print("<TR><TD>$type_examples[$index]</TD>");
    $converted_var =
       (int) $type_examples[$index];
    print("<TD>$converted_var</TD>");
    $converted_var =
       (double) $type_examples[$index];
    print("<TD>$converted_var</TD>");
    $converted_var =
       (string) $type_examples[$index];
    print("<TD>$converted_var</TD>");
    $converted_var =
       (array) $type_examples[$index];
    print("<TD>$converted_var</TD></TR>");
  }
print("</TABLE>");
?>

