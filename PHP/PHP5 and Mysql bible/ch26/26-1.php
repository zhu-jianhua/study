<!-- Listing 26-1: A substitution cipher -->
<?php
/* Part 1 - cipher algorithm and utility functions */
function add_1 ($num)
{
  return(($num + 1) % 26);
}

function sub_1 ($num)
{
  return(($num + 25) % 26);
}

function swap_2 ($num)
{
  if ($num % 2 == 0)
    return($num + 1);
  else
    return($num - 1);
}

function swap_26 ($num)
{
  return(25 - $num);
}

function lower_letter($char_string)
{
 return ((ord($char_string) >= ord('a')) &&
         (ord($char_string) <= ord('z')));
}

function upper_letter($char_string)
{
 return ((ord($char_string) >= ord('A')) &&
         (ord($char_string) <= ord('Z')));
}

/* Part 2 - the letter_cipher function */
function letter_cipher ($char_string, $code_func)
{
  if (!(upper_letter($char_string) ||
        lower_letter($char_string)))
    return($char_string);
  if (upper_letter($char_string))
    $base_num = ord('A');
  else
    $base_num = ord('a');
  $char_num = ord($char_string) -
                  $base_num;
  return(chr($base_num +
              ($code_func($char_num)
               % 26)));
}

/* Part 3 - the main string_cipher function */
function string_cipher($message, $cipher_func)
{
  $coded_message = "";
  $message_length = strlen($message);
  for ($index = 0;
       $index < $message_length;
       $index++)
    $coded_message .=
      letter_cipher($message[$index], $cipher_func);
  return($coded_message); 
}
?>

