<?php
include("../dbvars.php"); // sets $host, $user, $pass
require_once 'DB.php';
$dsn = "mysql://$user:$pass@$host/'user ratings'";
$db = DB::connect($dsn);
if (DB::isError($db)) {
    die ($db->getMessage());
}
?>
