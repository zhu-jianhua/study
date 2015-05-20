<?php 
include_once("dbconnect_vars.php");

class Book 
{
var $id;

// variables corresponding to DB columns
var $author = "DBSET"; 
var $title = "DBSET";
var $publisher = "DBSET";

  function __construct($db_connection, $id) {
    $this->id = $id;
    $query = "select * from book " .
             "where id = $id";
    $result = mysql_query($query, $db_connection);
    $db_row_array = 
      mysql_fetch_array($result);
    $class_var_entries = 
      get_class_vars(get_class($this));
    while ($entry = each($class_var_entries)) {
      $var_name = $entry['key'];
      $var_value = $entry['value'];
      if ($var_value == "DBSET") {
        $this->$var_name = 
          $db_row_array[$var_name];
      }
    }
  }

  function toString () {
    $return_string = "BOOK<BR>";
    $class_var_entries = 
      get_class_vars(get_class($this));
    while ($entry = each($class_var_entries)) {
      $var_name = $entry['key'];
      $var_value = $this->$var_name;  
      $return_string .=
        "$var_name: $var_value<BR>";
    }
    return($return_string);
  }
}
$connection =
  mysql_connect($host, $user, $pass)
  or die("Could not connect to DB");
mysql_select_db("oop");
$book = new Book($connection, 1);
$book_string = $book->toString();
?>
<HTML><HEAD></HEAD><BODY>
<?php echo $book_string ?>
</BODY></HTML>
