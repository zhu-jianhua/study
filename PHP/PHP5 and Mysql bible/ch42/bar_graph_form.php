<?php
include_once("dbconnect.php");
include_once("bar_graph.php");

if (IsSet($_POST['COLUMN_NAME'])) {
  $column_name = $_POST['COLUMN_NAME'];
  $query = "select $column_name, count(*)
            from programmers
            group by $column_name";
  $result = mysql_query($query)
            or die("Error in database interaction<BR>".
                    mysql_error());
  $array_collection = array();
  while ($row = mysql_fetch_row($result)) {
    $name = $row[0];
    $count = $row[1];
    $array_collection[$name] = $count;
  }
  $bar_graph = 
    array_to_bar_graph($array_collection,
                       300);
}
else {
  $bar_graph = "";
}

$self = $_SERVER['PHP_SELF'];
$form = <<<EOT
<FORM METHOD=POST ACTION="$self">
<H3>Choose a table column for graphing</H3>
<SELECT NAME=COLUMN_NAME>
<OPTION VALUE=os>os
<OPTION VALUE=language>language
<OPTION VALUE=continent>continent
<OPTION VALUE=sex>sex
</SELECT>
<INPUT TYPE=SUBMIT NAME=SUBMIT>
</FORM>
EOT;

$page = <<<EOT
<HTML><HEAD><TITLE>Survey data</TITLE></HEAD>
<BODY>
$form
<BR>
$bar_graph
</BODY></HTML>
EOT;

echo $page;
?>
