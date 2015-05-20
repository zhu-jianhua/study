<!-- Listing 17-5: editing data from database (comment_edit.php) -->
<?php

// Open connection to the database
mysql_connect("localhost", "phpuser", "sesame") or die("Failure to communicate with database");
mysql_select_db("test");

if ($_POST['submit'] == 'Submit') {
  // Format the data
  $comment_id = $_POST['comment_id'];
  $comment_header = $_POST['comment_header'];
  $as_comment_header = addslashes($comment_header);
  $comment = $_POST['comment'];
  $as_comment = addslashes($_POST['comment']);

  // Update values
$query = "UPDATE comments
            SET comment_header = '$as_comment_header',
            comment = '$as_comment'
            WHERE ID = $comment_id";
  $result = mysql_query($query);
  if (mysql_affected_rows() == 1) {
    $success_msg = '<P>Your comment has been updated.</P>';
  } else {
    error_log(mysql_error());
    $success_msg = '<P>Something went wrong.</P>';
  }
} else {
  // Get the comment header and comment
  $comment_id = $_GET['comment_id'];
  $query = "SELECT comment_header, comment
            FROM comments
            WHERE ID = $comment_id";
  $result = mysql_query($query);
  $comment_arr = mysql_fetch_array($result);
  $comment_header = stripslashes($comment_arr[0]);
  $comment = stripslashes($comment_arr[1]);
}


$thispage = $_SERVER['PHP_SELF']; //Have to do this for heredoc

$form_page = <<< EOFORMPAGE
<STYLE TYPE="text/css">
<!--
BODY, P      {color: black; font-family: verdana; font-size: 10 pt}
H1        {color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</HEAD>

<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Comment edit</H1>

$success_msg
<FORM METHOD="post" ACTION="$thispage">
<INPUT TYPE="text" SIZE="40" NAME="comment_header" VALUE="$comment_header"><BR><BR>
<TEXTAREA NAME="comment" ROWS=10 COLS=50>$comment</TEXTAREA><BR><BR>
<INPUT TYPE="hidden" NAME="comment_id" VALUE="$comment_id">
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>

</TD></TR></TABLE>
</BODY>
</HTML>
EOFORMPAGE;
echo $form_page;
?>
