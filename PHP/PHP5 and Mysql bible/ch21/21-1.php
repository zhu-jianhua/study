<!-- Listing 21-1: Testing shuffle() -->
<?php
srand((double) microtime() * 1000000);

function run_tests() {
   global $shuffle_counts;
   $shuffle_array = array(0,1,2,3,4,5,6,7,8,9);
   shuffle($shuffle_array);

   $element_counter = 0;
   foreach ($shuffle_array as $element) {
     if (isSet($shuffle_counts[$element_counter][$element])) {
        $shuffle_counts[$element_counter][$element] += 1;
     }
     else {
        $shuffle_counts[$element_counter][$element] = 1;
     }
     $element_counter++;
   }
}

for ($i = 0; $i < 1000; $i++) {
  run_tests();
}

print("<H3>Counts from shuffled arrays</H3>");
print("<TABLE BORDER=1><TR>");
print("<TH>Positions:</TH>");
for ($pos = 0; $pos < 10; $pos++) {
  print("<TH>$pos</TH>");
}
print("</TR>");
for ($val = 0; $val < 10; $val++) {
  print("<TR><TH>Value $val</TH>");
  for ($pos = 0; $pos < 10; $pos++) {
    print("<TD>" . $shuffle_counts[$pos][$val]. "</TD>");
  }
  print("</TR>");
}
print("</TABLE>");
?>
