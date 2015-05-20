<!-- Listing 16-1: A table displayer -->
<?php
include("/home/phpbook/phpbook-vars.inc");
$global_dbh = mysql_connect($hostname, $username, $password);
mysql_select_db($db, $global_dbh);

function display_db_table($tablename, $connection)
{
  $query_string = "select * from $tablename";
  $result_id = mysql_query($query_string, $connection);
  $column_count = mysql_num_fields($result_id);

  print("<TABLE BORDER=1>\n");
  while ($row = mysql_fetch_row($result_id))
    {
      print("<TR ALIGN=LEFT VALIGN=TOP>");
      for ($column_num = 0;
           $column_num < $column_count;
           $column_num++)     
        print("<TD>$row[$column_num]</TD>\n");
      print("</TR>\n");
    }
    print("</TABLE>\n");
}
?>

<HTML>
<HEAD>
<TITLE>Cities and countries</TITLE>
</HEAD>
<BODY>

<TABLE><TR><TD>
<?php display_db_table("country", $global_dbh); ?>
</TD><TD>
<?php display_db_table("city", $global_dbh); ?>
</TD></TR></TABLE></BODY></HTML>
