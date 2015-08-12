<?php

// Definitions and utility functions for the
//  Certainty Quiz game
error_reporting(E_ALL);
// enumeration constants for the scaling of distractors
define("CERTAINTY_LINEAR", 1);
define("CERTAINTY_GEOMETRIC", 2);

// Seed the random number generator
srand((double) microtime() * 1000000);

// A hack to retrieve the value of POST values
//   without explicitly checking PHP versions.
function get_post_value ($var_name) {
  global $HTTP_POST_VARS;
  if (IsSet($_POST) &&
      IsSet($_POST[$var_name])) {
    return($_POST[$var_name]);
  }
  elseif (IsSet($HTTP_POST_VARS) &&
          IsSet($HTTP_POST_VARS[$var_name])) {
    return($HTTP_POST_VARS[$var_name]);
  }
  else {
    return(FALSE);
  }
}

function get_session_value ($var_name) {
  global $HTTP_SESSION_VARS;
  if (IsSet($_SESSION) &&
      IsSet($_SESSION[$var_name])) {
    return($_SESSION[$var_name]);
  }
  elseif (IsSet($HTTP_SESSION_VARS) &&
          IsSet($HTTP_SESSION_VARS[$var_name])) {
    return($HTTP_SESSION_VARS[$var_name]);
  }
  else {
    return(FALSE);
  }
}

function set_session_value ($var_name, $value) {
  global $HTTP_SESSION_VARS;
  if (IsSet($_SESSION)) {
    $_SESSION[$var_name] = $value;
    $HTTP_SESSION_VARS[$var_name] = $value;
  }
  else {
    $HTTP_SESSION_VARS[$var_name] = $value;
  }
}

function unset_session_value ($var_name) {
  global $HTTP_SESSION_VARS;
  if (IsSet($_SESSION)) {
    unset($_SESSION[$var_name]);
    unset($HTTP_SESSION_VARS[$var_name]);
  }
  else {
    $HTTP_SESSION_VARS[$var_name] = $value;
  }
}

// Numerical functions

function round_to_digits ($number, $digits) {
  if ($number < 0) {
    return(- round_to_digits(- $number, $digits));
  }
  else if ($number == 0) {
    return($number);
  }
  else {
    $tens = 
      floor(log10($number));
    $divisor = pow(10, ($tens - $digits));
    $significant = (1.0 * $number) / 
      $divisor;
    $rounded = round($significant);
    return($rounded * $divisor);
  }
}

function nth_root_initial($product, $n)
{
  $estimate = sqrt($product);
  $roots = 2;
  while ($roots < $n) {
    $estimate = sqrt($estimate);
    $roots = $roots * 2;
  }
  return($estimate);
}

function nth_root ($product, $n) {
  if (($product <= 1) ||
      ($n < 2)) {
    die("Arguments to nth_root should be ".
        "product (greater than 1) and " .
        "n (greater than 1)");
  }
  $initial_estimate = 
    nth_root_initial($product, $n);
  return(nth_root_aux($product, $n,
           $initial_estimate,
           20000,
           0.0001));
}

function nth_root_aux ($product, $n,
                       $guess, 
                       $iterations_left,
                       $desired_difference) {
  if ($iterations_left <= 0) {
    return($guess);
  }
  else {
    $guessed_product = pow($guess, $n);
    if (abs($guessed_product - $product) 
        < $desired_difference) {
      return($guess);
    }
    else {
      $new_guess = 
        $guess - 
          ((pow($guess, $n) - $product) /
            ($n * pow($guess, $n-1)));
      return(nth_root_aux($product, $n, 
                          $new_guess, 
                          $iterations_left - 1,
                          $desired_difference));
    }
  }
}

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
?>
