<!-- Listing 38-7: Results listing (results.php) -->
<HTML>
<HEAD></HEAD>

<BODY BGCOLOR=#666680 TEXT=#ffffff>
<TABLE CELLPADDING=30><TR><TD>
<B>Da Results</B><BR><BR>
<?php
$filling = $_POST['filling'];
$cheese = $_POST['cheese'];
$bread = $_POST['bread']; 

if ($filling) {
  if (is_array($filling)) {
    reset($filling);
    while (list($key, $value) = each($filling)) {
      echo("$value<BR>\n");
    }
  } else {
    echo($filling);
  }
}
?>
<BR><BR></TD>
<TD VALIGN=top><BR><BR>
<B>Cheese</B><BR><BR>
<?php echo($cheese); ?>
<BR><BR></TD>
<TD VALIGN=top><BR><BR>
<B>Bread</B><BR><BR>
<?php echo($bread); ?>
</TD></TR>
</TABLE>
</BODY>
</HTML>
