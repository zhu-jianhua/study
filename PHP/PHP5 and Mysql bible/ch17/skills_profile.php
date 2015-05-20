<!-- Listing 17-8: select list displaying database values (skills_profile.php) -->
<?php

$user_id = $_COOKIE['user_id'];

// Open connection to the database
mysql_connect("localhost", "mysqluser", "sesame") or die("Database error!");
mysql_select_db("test");

if ($_POST['submit'] == 'Submit') {

  // Delete this user's skills
  $query2 = "DELETE FROM user_skill
             WHERE user_id = $user_id";
  $result2 = mysql_query($query2);

  foreach ($_POST['skills'] as $val) {
    $query = "INSERT INTO user_skill (ID, user_id, skill_id) VALUES (NULL, $user_id, $val)";
    $result = mysql_query($query);
    if (mysql_affected_rows() == 1) {
      continue;
    } else {
      error_log(mysql_error());
      $error_msg = '<P>Something went wrong</P>';
      break;
    }
  }
}

// Get all the results
$query = "SELECT * FROM skills";
$result = mysql_query($query);

// Download this user's skills
$query1 = "SELECT skill_id
           FROM user_skill
           WHERE user_id = $user_id";
$result1 = mysql_query($query1);
while ($user_skill = mysql_fetch_array($result1)) {
  $skill_id = $user_skill[0];
  $user_skill_arr[$skill_id] = $skill_id;
}


while ($skills = mysql_fetch_array($result)) {
  $key = $skills[0];
  if ($key == $user_skill_arr[$key]) {
    $select_str .= "<OPTION VALUE=\"$key\" SELECTED>$skills[1]\n";
  } else {
    $select_str .= "<OPTION VALUE=\"$key\">$skills[1]\n";
  }
}


$thispage = $_SERVER['PHP_SELF']; //Have to do this for heredoc
$form_str = <<< EOFORMSTR
<HTML>
<HEAD>
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
<H1>Skills profile</H1>
<P>Select as many skills from the following list as apply.  Hold down the control key to select multiple skills.</P>
$error_msg

<FORM METHOD=POST ACTION="$thispage">
<SELECT NAME="skills[]" SIZE=10 MULTIPLE>
$select_str
</SELECT>
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>

</TD></TR></TABLE>
</BODY></HTML>
EOFORMSTR;
echo $form_str;

?>

