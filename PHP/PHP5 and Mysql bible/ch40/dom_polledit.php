<html>
<head>
<title>Poll XML editor</title>
</head>

<body>
<?php

$doc = new DomDocument();
$pollfile = "poll.xml";


// Handle form submission
if ($_POST['stage'] == 1) {
  // Reading in the XML file as a DOM object
  if (!$doc->load($pollfile)) {
    echo "Cannot read XML file.";
    exit;
  }

  // Once a poll is created, the user will only be able to 
  // change the StartDate, EndDate, Question, and response values.

  // Format the data
  $pollname = $_POST['poll_name'];
  $startdate = $_POST['Poll_Startdate'];
  $enddate = $_POST['Poll_Enddate'];
  $question = $_POST['Poll_Question'];

  // Replace the values as text nodes
  $poll_list = $doc->getElementsByTagname("Poll");
  foreach ($poll_list as $poll_obj) {
    // Figure out which poll we're editing, then work on its children
    $pollname_value = $poll_obj->getAttribute("id");
    if ($pollname_value == $pollname) {
      $children = $poll_obj->childNodes;
      foreach ($children as $child_obj) {
        $node_name = $child_obj->nodeName;
        $value = $child_obj->nodeValue;
        if ($node_name == "StartDate") {
          if ($value == $startdate) {
            // Do nothing
          } else {
            $sd_textnode = $child_obj->firstChild;
            $new_startdate = $doc->createTextNode($startdate);
            $child_obj->replaceChild($new_startdate, $sd_textnode);
          }
        }
        if ($node_name == "EndDate") {
          if ($value == $enddate) {
            // Do nothing
          } else {
            $ed_textnode = $child_obj->firstChild;
            $new_enddate = $doc->createTextNode($enddate);
            $child_obj->replaceChild($new_enddate, $ed_textnode);
          }
        }
        if ($node_name == "question") {
          if ($value == $enddate) {
            // Do nothing
          } else {
            $q_textnode = $child_obj->firstChild;
            $new_question = $doc->createTextNode($question);
            $child_obj->replaceChild($new_question, $q_textnode);
          }
        }
        if ($node_name == "responseSet") {
          $old_responses = $child_obj->childNodes;
          $i=0;
          foreach ($old_responses as $delete_responses) {
            if ($delete_responses->nodeName == 'response') {
              $r_textnode = $delete_responses->firstChild;
              $new_response = $doc->createTextNode($_POST['response'][$i]);
              $delete_responses->replaceChild($new_response, $r_textnode);
              $i++;
            }
          }
        }
      }
    }
  }

  // Write out the file
  $doc->save($pollfile);

}

// This stuff happens every time, whether a submission
// has occurred or not.

// Reading in the XML file as a DOM object
// Must read fresh every time
if (!$doc->load($pollfile)) {
  echo "Cannot read XML file.";
  exit;
}
  
// Get a list of the polls in this XML document
// and then pull out the start date, end date,
// poll question, and possible responses.
$poll_list = $doc->getElementsByTagname('Poll');
foreach ($poll_list as $poll_obj) {
  $id = $poll_obj->getAttribute("id");
  $children = $poll_obj->childNodes;
  foreach ($children as $key=>$child_obj) {
    $node_name = $child_obj->nodeName;
    if ($node_name != "#text" && $node_name != 'responseSet') {
      $content_str = $child_obj->nodeValue;
      $poll_array["$node_name"] = $content_str;
    } elseif ($node_name == 'responseSet') {
      // Get the responses
      $responselist = $child_obj->childNodes;
      foreach ($responselist as $responses) {
        $response_name = $responses->nodeName;
        if ($response_name != "#text") {
          $response_array[] = $responses->nodeValue;
        }
      }
    } 
  }

  // Arrange all the data nicely
  $poll_startdate = $poll_array['StartDate'];
  $poll_enddate = $poll_array['EndDate'];
  $poll_name = $poll_array['name'];
  $poll_question = $poll_array['question'];
  $poll_question = stripslashes($poll_question);
  foreach ($response_array as $key=>$val) {
    $resp_str .= "Option:  <INPUT TYPE=\"text\" SIZE=25 NAME=\"response[$key]\" VALUE=\"$val\"><BR>\n";
  }

  // Display form with old values
  $php_self = $_SERVER['PHP_SELF'];
$form = <<< EOFORM
<FORM METHOD="post" ACTION="$php_self">
Start Date:  <INPUT TYPE="text" SIZE=10 NAME="Poll_Startdate" VALUE="$poll_startdate"><BR>
End date:  <INPUT TYPE="text" SIZE=10 NAME="Poll_Enddate" VALUE="$poll_enddate"><BR>
Poll question:  <INPUT TYPE="text" SIZE=100 NAME="Poll_Question" VALUE="$poll_question"><BR>
$resp_str
<INPUT TYPE="hidden" NAME="poll_name" VALUE="$id">
<INPUT TYPE="hidden" NAME="stage" VALUE=1><BR>
<INPUT TYPE="submit" VALUE="Presto-chango">
</FORM>


EOFORM;
  echo $form;
  unset($resp_str);
  unset($response_array);
}
?>

</body>
</html>
