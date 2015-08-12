<HTML><HEAD><TITLE>DB Visualization</TITLE></HEAD>
<BODY>

<B>Choose one from each column, and we'll
display the intersection from the survey data:<BR>
<FORM METHOD=POST ACTION="db_visualization.php"
      TARGET=new >

<TABLE>

<?php
include("query_clauses.php");
for ($x = 0; $x < count($QUERY_CLAUSES); $x++) {
  print("<TR><TD><INPUT
	       TYPE=RADIO NAME=\"left_clause\"
	       VALUE=$x>".
	       $QUERY_DESCRIPTION[$x] . "</TD>
             <TD><INPUT
	       TYPE=RADIO NAME=\"right_clause\"
	       VALUE=$x>".
	       $QUERY_DESCRIPTION[$x] . "</TD></TR>");
}
?>

</TABLE>
<INPUT TYPE=HIDDEN NAME="table" VALUE="programmers">
<INPUT TYPE=SUBMIT NAME=SUBMIT>
</FORM>

</BODY>
</HTML>
