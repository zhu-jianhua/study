<?php

// include the file which will validate the user ID
require_once('includes/user_functions.php');

// retrieve the user ID to validate
$user_id = $_POST('user_id');

try {
  
  // set the display message based on whether or not the
  // user ID is valid
  if (!is_valid_user($user_id)) {
    $msg = "Sorry, $user_id is not a valid user ID.";
  } else {
    $msg = "$user_id is a valid user ID.";

} catch(Exception $ex) {

  // retrieve the message from the exception object
  $msg = ($ex->getMessage());

}

function is_valid_user($user_id) {
    
  // throw an exception if the user ID does not begin with "usr"
  $pre_str = "usr";
  if ((strpos($user_id, $pre_str) === false) ||
    (strpos($user_id, $pre_str) != 0)) {
    throw new Exception('$user_id does not contain the proper prefix.');
  }

  // throw an exception if the user ID is not the proper length
  if ((strlen($user_id) < 9)) {
    throw new Exception('$user_id is less than the required length.');
  }

  if (validate($user_id)) {
    // user ID was found in the database
    return true;
  } else {
      // the specified user ID does not exist in the database
    return false;
  }

}
?>
