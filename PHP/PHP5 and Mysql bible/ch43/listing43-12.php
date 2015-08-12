<?php
// You'll probably have to be the root MySQL user to run 
// this script.If you can't get that permission, you could
            // alter the script below to create tables in your pre-existing
            // database.
include("/home/htmluser/db_password.inc");

mysql_connect($hostname, $user, $password)
  or die("Failure to communicate");
$try_create = mysql_create_db("weblogs");
if ($try_create > 0) {
  echo ("Successfully created database.<BR>\n");
  mysql_select_db("weblogs");
  $query = "CREATE TABLE login (ID SMALLINT NOT NULL
AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20), password
VARCHAR(20))";
  $result = mysql_query($query);
  // Since we're not using the standard MySQL
  // date format, store date as an integer
  $query2 = "CREATE TABLE mylog (ID SMALLINT NOT NULL
AUTO_INCREMENT PRIMARY KEY, date INT(8), blogtext TEXT)";
  $result2 = mysql_query($query2);
  mysql_close();
  if ($result > 0 && $result2 > 0) {
    echo ("Successfully created tables<BR>\n");
  } else {
    echo ("Unable to create tables.");
  }
} else {
  echo ("Unable to create database");
}
?>