<!-- Listing 34-4: edit.php -->
<html>
<head>
	<title>Cartoons Database</title>
</head>
<body>
<h1>Cartoons and Characters Database</h1>
<?php
$connect_parameters = "host=localhost dbname=sample
user=cartoonfan password=secretword";
$link = pg_connect($connect_parameters);
if ($_POST[action] == "Update") {
	$sSql = "update cartoons set cartoon = '$_POST[cartoon]' where id = '$_POST[f]'";
	if (pg_query($sSql)) {
		$dSql = "delete from characters where id = '$_POST[f]'";
		pg_query($dSql);
		$characters_array = explode( "\n", $_POST[characters]);
		for($i=0;$i<count($characters_array);$i++) {
			$char = trim($characters_array[$i]);
			if($char <> '') {
				$cSql = "insert into characters
                        (id, character) 
				values($_POST[f], '$char')";
				pg_query($cSql);
			}
		}
		print("<p>Your edits were successfully posted.</p>");
	} else {
		print("<p>Update of record $_POST[f] failed.</p>");
	}
	print("<p><a href=\"index.php\">Return to the main
   page.</a></p>");
} else {
	$sSql = "select * from cartoons where id = $_GET[f]";
	$sResult = pg_query($sSql);
	$sRow = pg_fetch_object($sResult);
	print("<form action=\"edit.php\" method=\"post\">");
	print("<p>Edit the name of a favorite cartoon<br>");
	print("<input type=\"hidden\" name=\"f\" value=\"$_GET[f]\">");
	print("<input type=\"text\" name=\"cartoon\"
     value=\"$sRow->cartoon\"></p>");
	print("<p>Edit the name of some characters from
     the cartoon. ");
	print("(You can enter more later). Use a hard return to ");
	print("separate each name.<br>");
	print("<textarea cols=\"15\" rows=\"8\" name=\"characters\">");
	$cSql = "select * from characters where id = $_GET[f]";
	$cResult = pg_query($cSql);
	while ($cRow = pg_fetch_object($cResult)) {
		print("$cRow->character\r\n");
	}
	print("</textarea></p>");
	print("<input type=\"submit\" name=\"action\" 
     value=\"Update\">");
	print("</form>");
	print("<p><a href=\"index.php\">Return to the main 
       page.</a></p>");
}
?>
</body>
</html>


