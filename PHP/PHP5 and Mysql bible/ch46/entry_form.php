<?php
include_once("certainty_utils.php");
include_once("game_parameters_class.php");
$params = new GameParameters();
$connection = $params->getDbConnection();

if (get_post_value('POSTCHECK')) {
  handleEntryForm();
}
displayEntryForm();

function handleEntryForm () {
  $question = get_post_value('QUESTION');
  $answer = get_post_value('ANSWER');
  $lower_limit = get_post_value('LOWER_LIMIT');
  $upper_limit = get_post_value('UPPER_LIMIT');
  $level = get_post_value('LEVEL');
  $subject = get_post_value('SUBJECT');
  $scaling_type = get_post_value('SCALING_TYPE');
  $attribution = get_post_value('ATTRIBUTION');
  if ($upper_limit > $lower_limit) {
    $query = 
      "insert into question 
       (question, answer, lower_limit, upper_limit,
        level, subjectID, scaling_type,
        attribution)
       values
       ('$question', $answer, $lower_limit, $upper_limit,
        $level, $subject, $scaling_type,
        '$attribution')";
    $result = mysql_query($query);
    if ($result) {
      print("Entry was successful<BR>");
    }
    else {
      print("Entry was not successful<BR>");
    }
  }
  else {
    print("Upper limit must be > lower<BR>");
  }
}

function displayEntryForm () {
$PHP_SELF = $_SERVER['PHP_SELF'];
$linear = CERTAINTY_LINEAR;
$geometric = CERTAINTY_GEOMETRIC;
$subject_string = make_subject_string();
$form_string = <<<EOT
<FORM METHOD=POST TARGET="$PHP_SELF" >
Question:
<INPUT TYPE=TEXT NAME=QUESTION SIZE=60 ><BR>
Answer:
<INPUT TYPE=TEXT NAME=ANSWER><BR>
Lower:
<INPUT TYPE=TEXT NAME=LOWER_LIMIT><BR>
Upper:
<INPUT TYPE=TEXT NAME=UPPER_LIMIT><BR>
Level:
<INPUT TYPE=TEXT NAME=LEVEL><BR>
Subject:
$subject_string<BR>
Scaling type:
<SELECT NAME=SCALING_TYPE>
  <OPTION VALUE=$linear>Linear
  <OPTION VALUE=$geometric>Geometric
</SELECT><BR>
Attribution:
<INPUT TYPE=TEXT NAME=ATTRIBUTION><BR>
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=SUBMIT>
<INPUT TYPE=HIDDEN NAME=POSTCHECK VALUE=1>
</FORM>
EOT;
echo $form_string;
}

function make_subject_string () {
  $result_string = "<SELECT NAME=SUBJECT>";
  $query = "select id, subject from subject order by id";
  $result = mysql_query($query);
  while ($row = mysql_fetch_row($result)) {
    $id = $row[0];
    $display = $row[1];
    $result_string .= "<OPTION VALUE=$id>$display";
  }
  $result_string .= "</SELECT>";
  return($result_string);
}
?>
