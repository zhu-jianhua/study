<!-- Listing 37-7: Random password generation functions (password_maker.inc) -->
<?php
// random_string is the function you actually call,
// and it in turn uses random_char

function random_char($string)
{
$length = strlen($string);
$position = mt_rand(0, $length - 1);
return($string[$position]);
}

function random_string ($charset_string, $length)
{
$return_string = random_char($charset_string);
for ($x = 1; $x < $length; $x++)
$return_string .= random_char($charset_string);
return($return_string);
} 

// magic line to seed random generator
mt_srand((double)microtime() * 1000000);

$charset = "abcdefghijklmnopqrstuvwxyz";
?>
