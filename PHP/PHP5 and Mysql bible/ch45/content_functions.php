<?php

require_once 'DB.php';

function make_content_box($current_page, $content_id) {
  $query = 
    "select quotation, attribution from quotations
       where ID = $content_id";
  $result = $db->query($query);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }

if ($result->numRows() != 0) {
while ($row = $result->fetchRow()){
  $quotation = $row[0];
  $attribution = $row[1];
  $return_string .= 
       "<table align=top><tr align=top>
        <td>\"$quotation\"<br>
        --- $attribution</td></tr></table>";
  }
}
  else {
    return("No content in database");
  }
$db->disconnect();

  }
}

function make_next_prev_box ($current_page, $current_id) {
  $prev_id = prev_content_id($current_id);
  $next_id = next_content_id($current_id);
  return("<TABLE><TR><TD>
          <A HREF=\"$current_page?RATED_ID=$prev_id\">
           Prev quote</A>
          </TD><TD>
          <A HREF=\"$current_page?RATED_ID=$next_id\">
           Next quote</A>
          </TD></TR></TABLE>");
}

function next_content_id ($current_id) {
 $query = "select ID from quotations 
            where ID > $current_id 
            order by ID asc";
     
 $result = $db->query($query);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }

if ($result->numRows() != 0) {
$row = $result->fetchRow()
$id = $row[0];
}
  else {
    $query = "select min(ID) from quotations";
    $result = $db->query($query);
    if (DB::isError($result)) 
    {
      $errorMessage = $result->getMessage();
      die ($errorMessage);
    }
  $row = $result->fetchRow()
  $id 	=	$row[0];
  }
  $db->disconnect();
 return($id);  
}

function prev_content_id ($current_id) {
  $query = "select ID from quotations 
            where ID < $current_id 
            order by ID desc";

 $result = $db->query($query);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }

if ($result->numRows() != 0) {
$row = $result->fetchRow()
$id = $row[0];
}
  else {
    $query = "select max(ID) from quotations";
    $result = $db->query($query);
    if (DB::isError($result)) 
    {
    $errorMessage = $result->getMessage();
    die ($errorMessage);
    }
  $row = $result->fetchRow()
  $id = $row[0];
  }
  $db->disconnect();
 return($id);  
}

?>
