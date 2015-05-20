<?php
include_once("dbconnect.php");
include_once("query_clauses.php");
include_once("venn.php");

if (IsSet($_POST['table']) && 
    IsSet($_POST['left_clause']) &&
    IsSet($_POST['right_clause'])) {
  $table = $_POST['table'];
  $left_clause_id = $_POST['left_clause'];
  $right_clause_id = $_POST['right_clause'];

  $left_clause = $QUERY_CLAUSES[$left_clause_id];
  $right_clause = $QUERY_CLAUSES[$right_clause_id];

  visualize_intersection ($table, $left_clause,
                                  $right_clause);
}
else {
  print("Form submission not handled correctly.<BR>".
        "Did you choose all options?");
}

function visualize_intersection ($table, $left_clause, 
                                 $right_clause) 
{

  $left_query = "select count(*) from $table
                 where $left_clause";
  $right_query = "select count(*) from $table
                 where $right_clause";
  $intersection_query = 
                 "select count(*) from $table
                 where $left_clause and $right_clause";

  $result = mysql_query($left_query) 
    or die("Query was $left_query:" . mysql_error());
  $row = mysql_fetch_row($result);
  $left_count = $row[0];

  $result = mysql_query($right_query) 
    or die(mysql_error());
  $row = mysql_fetch_row($result);
  $right_count = $row[0];

  $result = mysql_query($intersection_query) 
    or die(mysql_error());
  $row = mysql_fetch_row($result);
  $intersection_count = $row[0];

  venn_visualization($left_count, $left_clause,
                     $right_count, $right_clause,
                     $intersection_count);
}
?>
