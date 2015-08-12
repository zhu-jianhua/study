<?php
require_once 'DB.php';
require_once('dbSpec.php');

function getItems()
{
global $phptype;
global $hostspec;
global $database;
global $username;
global $password;

$dsn = "$phptype://$username:$password@$hostspec/$database";
$db = DB::connect($dsn);
if (DB::isError($db)) 
{
die ($db->getMessage());
}

$sql = "select id, desc, weight, packageQty, unit, supplierID, cost from INVENTORY_item";
That's the SQL query that is to be sent to the database server. Note that we specify the columns, even though it's all of them. That way we know what order the columns will be in when results come back.
$result = $db->query($sql);
if (DB::isError($result)) 
	{
	$errorMessage = $result->getMessage();
	die ($errorMessage);
	}

$returnArray = array();
while ($row = $result->fetchRow()) 
	{
	$id 		=	$row[0];
	$desc		=	$row[1];
	$weight		=	$row[2];
	$packageQty	= 	$row[3];
	$unit		=	$row[4];
	$supplierID	= 	$row[5];
	$cost		=	$row[6];
	$returnArray[] = array('id' => $id, 'desc' => $ desc, 'weight' => $weight, 'packageQty' => $packageQty, 'unit' => $unit, 'supplierID' => $ supplierID, 'cost' => $cost);
	}
$db->disconnect();
return $returnArray;
}
?>
