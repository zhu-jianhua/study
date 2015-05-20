<!-- Listing 16-2: A query displayer -->
<?php
include("/home/phpbook/phpbook-vars.inc");
$global_dbh = mysql_connect($hostname, $username, $password)
                or die("Could not connect to database");

mysql_select_db($db, $global_dbh)
  or die("Could not select database");

function display_db_query($query_string, $connection,
                          $header_bool, $table_params)
{
  
  // perform the database query
  $result_id = mysql_query($query_string, $connection)
               or die("display_db_query:" . mysql_error());

  // find out the number of columns in result
  $column_count = mysql_num_fields($result_id)
                  or die("display_db_query:" . mysql_error());

  // TABLE form includes optional HTML arguments passed
  //  into function
  print("<TABLE $table_params >\n");

  // optionally print a bold header at top of table
  if ($header_bool)
  {
    print("<TR>");
    for ($column_num = 0;
          $column_num < $column_count;
          $column_num++)
    {
      $field_name =
         mysql_field_name($result_id, $column_num);
      print("<TH>$field_name</TH>");
     }
     print("</TR>\n");
  }
  // print the body of the table
  while ($row = mysql_fetch_row($result_id))
  {
    print("<TR ALIGN=LEFT VALIGN=TOP>");
    for ($column_num = 0;
         $column_num < $column_count;
         $column_num++)
      {       
        print("<TD>$row[$column_num]</TD>\n");
      }
    print("</TR>\n");
  }
  print("</TABLE>\n");   }

function display_db_table($tablename, $connection,
                          $header_bool, $table_params)
{
  $query_string = "select * from $tablename";
  display_db_query($query_string, $connection,
                   $header_bool, $table_params);
}
?>

<HTML><HEAD><TITLE>Countries and cities</TITLE></HEAD>
<BODY>
<TABLE><TR><TD>
<?php display_db_table("country", $global_dbh,
                      TRUE, "BORDER=2"); ?>
</TD><TD>
<?php display_db_table("city", $global_dbh,
                      TRUE, "BORDER=2"); ?>
</TD></TR></TABLE></BODY></HTML>

