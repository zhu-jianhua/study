<!-- Listing 34-5: index.php (final) -->
<html>
<head>
	<title>Cartoons Database</title>
</head>

<body>

<h1>Cartoons and Characters Database</h1>

<p>Welcome to the cartoons and characters database. Existing
entries are provided below. Use the provided functions to get
more details and to edit, add or delete entries.</p>

<?php
$connect_parameters = "host=localhost dbname=sample
user=cartoonfan password=secretword";
if ($link = pg_connect($connect_parameters)) {

if($_GET[action] == "d") {
	$dSql = "delete from characters where id = '$_GET[f]'";
	pg_query($dSql);
	$dSql = "delete from cartoons where id = '$_GET[f]'";
	pg_query($dSql);
}
	$sSql = "select * from cartoons";
	$sResult = pg_query($link, $sSql);
	if (pg_num_rows($sResult) > 0) {
		print("<table border=\"1\">");
		print("<tr><th>ID</th><th>Cartoon</th>
		         <th>Characters</th><th></th></tr>");
		while ($sRow = pg_fetch_object($sResult)) {
			print("<tr><th>$sRow->id</th>
			      <td>$sRow->cartoon</td>");
			$tSql = "select * from characters where id = '$sRow->id'";
			$tResult = pg_query($tSql);
			print("<td>");
			$character_string = "";
			while ($tRow = pg_fetch_object($tResult)) {
				$character_string .= "$tRow->character, ";
			}
			$new_character_string = ereg_replace("(, )$", "",
			 $character_string);
			print("$new_character_string</td>");
			print("<td><a href=\"edit.php?f=$sRow->id\">Edit</a> |");
			print(" <a href=\"index.php?f=$sRow->id&action=d\">Delete</a></td></tr>");
		}
		print("</table>");
	} else {
		print("<p>There are not currently any records in the
		   cartoon database.</p>");
	}
	print("<p><a href=\"insert.php\">Add a Record</a></p>");
} else {
	print("<p>Connection to the cartoons database has failed</p>");
}
?>

</body>
</html>




