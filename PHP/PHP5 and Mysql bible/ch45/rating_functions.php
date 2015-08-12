<?php

function rating_types_as_array () {
  $return_array = array();
  $query =
  "select ID, rating_text from rating_values order by rank desc"
 
$result = $db->query($query);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }

while ($row = $result->fetchRow()) 
  {
    $id = $row_array['ID'];
    $text = $row_array['rating_text'];
    $return_array[$id] = $text;
  }
 return($return_array);
}

function maybe_handle_new_rating() {
  if (isSet($_POST['RATING_ID'])) {
    $new_rating = $_POST['RATING_ID'];
    $rated_id = $_POST['RATED_ID'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    handle_new_rating($new_rating, $rated_id,
                      $user_ip);
    return(true);
  }
  else {
    return(false);
  }
}

function handle_new_rating($new_rating, $rated_id, 
                           $user_ip) {
  $query = "insert into ratings
            (rating, rated_id, user_ip)
            values ($new_rating, $rated_id,
                    '$user_ip')";

$result = $db->query($query);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }
}


function make_ratings_box ($target_page, $rated_id) {
  $new_rating_handled = maybe_handle_new_rating();
  if ($new_rating_handled) {
    return(make_ratings_receipt_box());
  }
  else {
    return(make_ratings_submission_box($target_page,
                                       $rated_id));
  }
}

function make_ratings_receipt_box () {
  return("<TABLE BORDER=1><TR><TD>Thanks for voting!".
         "</TD></TR></TABLE>");
}

function make_ratings_submission_box 
  ($target_page, $rated_id) {
  $rating_array = rating_types_as_array();
  // Beginning of HTML table
  $return_string = 
   "<TABLE BORDER=1><TR><TD>What did you think?</TD></TR>".
   "<TR><TD ALIGN=LEFT><FORM METHOD=POST".
  "ACTION=\"$target_page\">";
  foreach ($rating_array as $id => $text) {
    $return_string .= 
      "<BR><INPUT TYPE=RADIO NAME=RATING_ID VALUE=\"$id\">" .
      "&nbsp $text</INPUT>";
  }
  $return_string .= 
   "<INPUT TYPE=HIDDEN NAME=RATED_ID VALUE=$rated_id>";
  $return_string .= 
   "<BR><CENTER><INPUT TYPE=SUBMIT 
    NAME=SUBMIT VALUE=\"Submit\"></CENTER>";
  $return_string .= "</FORM></TD></TR></TABLE>";
  return($return_string);
}

?>
