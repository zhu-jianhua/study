<!-- Listing 21-1: Testing a replacement for shuffle -->
<?php
srand((double) microtime() * 1000000);

function create_randomized_array ($in_array) {
   // Assumes input is simple list, with keys
   //  equal to 0,...,n 
   // Returns similar list, with keys as in input
   //  but values in randomized order
   // Assumes prior call to srand()
   $in_array_length = count($in_array);
   $working_array = array();
   for ($i = 0; $i < $in_array_length; $i++) {
      $rand_value = rand();
      $working_array[$i] = $rand_value;
   }
   asort($working_array);  // orders by random value
   $return_array = array();
   $working_keys = array_keys($working_array);
   foreach ($working_keys as $int_key) {
      array_push($return_array,
           $in_array[$int_key]);
   }
   return($return_array);
}
function run_tests() {
   global $random_counts;
   $random_array = array(0,1,2,3,4,5,6,7,8,9);
   $random_array = create_randomized_array($random_array);

   $element_counter = 0;
   foreach ($random_array as $element) {
     if (IsSet($random_counts[$element_counter][$element])) {
  $random_counts[$element_counter][$element] += 1;
     }
     else {
  $random_counts[$element_counter][$element] = 1;
     }
     $element_counter++;
   }
}

for ($i = 0; $i < 1000; $i++) {
  run_tests();
}

print("<H3>Counts from randomized arrays</H3>");
print("<TABLE BORDER=1><TR>");
print("<TH>Positions:</TH>");
for ($pos = 0; $pos < 10; $pos++) {
  print("<TH>$pos</TH>");
}
print("</TR>");
for ($val = 0; $val < 10; $val++) {
  print("<TR><TH>Value $val</TH>");
  for ($pos = 0; $pos < 10; $pos++) {
    print("<TD>" . $random_counts[$pos][$val]. "</TD>");
  }
  print("</TR>");
}
print("</TABLE>");

?>

