<!-- Listing 38-3: Dynamic JavaScript and PHP form (dyn_navigation.html) -->
<html>
<head>
<title>Navigation pulldown</title>
<script language="JavaScript">
<!--
function Browse(form, i){
  var site = form.elements[i].selectedIndex;
  if(site > 0){
    top.location = form.elements[i].options[site].value
  }
}
// -->
</script>
</head>

<body>
<form method="post" action="redirect.php">
<select name="category" onChange="Browse(this.form,0)">
<option selected value=0>Choose a Category</option>
<?php
mysql_connect("localhost", "user", "password");
mysql_select_db("site_db");
$query = "SELECT filename, my_text FROM categories WHERE display = 1";
$result = mysql_query($query);
while (list($filename, $my_text) = mysql_fetch_array($result)) {
  print("<option value=\"$filename\"> $my_text</option>\n");
}
?>
</select>
<input type="submit">
</form>
</body>
</html>

