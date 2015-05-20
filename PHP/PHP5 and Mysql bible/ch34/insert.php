<!-- Listing 34-2: insert.php -->
<html>
<head>
	<title>Cartoons Database</title>
</head>

<body>

<h1>Cartoons and Characters Database</h1>
<?php
if ($_POST[action] == "Insert") {
	$connect_parameters = "host=localhost dbname=sample
user=cartoonfan password=secretword";
	$link = pg_connect($connect_parameters);
	$iSql = "insert into cartoons(cartoon)
    values('$_POST[cartoon]')";
	if (pg_query($link, $iSql)) {
		$jSql = "select currval('cartoons_id_seq') as oid";
		$jResult = pg_query($jSql);
		$j_id = pg_fetch_result($jResult, 0, 'oid');
		$characters_array = explode( "\n", $_POST[characters]);
		for($i=0;$i<count($characters_array);$i++) {
			$char = trim($characters_array[$i]);
			$cSql = "insert into characters(id, character) 
			values($j_id, '$char')";
			pg_query($cSql);
		}
		print("<p>Your submission was successfully inserted.
		You can submit another, if you wish</p>");
	} else {
		print("<p>We were unable to insert the records as
          submitted. You can try again, if you wish</p>");
	}
} else {
	print("<p>Welcome to the cartoons and characters database. Enter the");
	print("name of your favorite cartoon below, and choose submit.</p>");
}

?>

<form action="insert.php" method="post">
<p>Enter the name of a favorite cartoon<br>
<input type="text" name="cartoon"></p>
<p>Enter the name of some characters from the cartoon. 
(You can enter more later). Use a hard return to
separate each name.<br>
<textarea cols="15" rows="8" name="characters">
</textarea></p>
<input type="submit" name="action" value="Insert">
</form>
<p><a href="index.php">Return to the main page.</a></p>
</body>
</html>



