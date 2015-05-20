<!-- Listing 6-2: Approximating a square root -->
<HTML>
<HEAD>
<TITLE>Approximating a square root</TITLE>
</HEAD>
<BODY>
<H3>Approximating a square root</H3>

<?php
$target = 81;
$guess = 1.0;
$precision = 0.0000001;

$guess_squared = $guess * $guess;
while (($guess_squared - $target > $precision) or
       ($guess_squared - $target < - $precision))
{
  print("Current guess: $guess is the square
         root of $target<BR>");
  $guess = ($guess + ($target / $guess)) / 2;
  $guess_squared = $guess * $guess;
}
print("$guess squared = $guess_squared<BR>");
?>
</BODY>
</HTML>

