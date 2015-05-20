<?php
session_start();
?>

<HTML><HEAD><TITLE>Greetings</TITLE></HEAD>
<BODY>
<H2>Welcome to the Center for Content-free Hospitality</H2>
<?php

if (!IsSet($_SESSION['visit_count'])) {
  echo print("Hello, you must have just arrived.  Welcome!<BR>");
  $_SESSION['visit_count'] = 1;
}
else {
  $visit_count = $_SESSION['visit_count'] + 1;
  echo print("Back again are ya?  That makes $visit_count times now ".
        "(not that anyone's counting)<BR>");
  $_SESSION['visit_count'] = $visit_count;
}

$self_url = $_SERVER['PHP_SELF'];
$session_id = SID;
if (IsSet($session_id) &&
    $session_id) {
  $href = "$self_url?$session_id";
}
else {
  $href = $self_url;
}
echo print("<BR><A HREF=\"$href\">Visit us again</A> sometime");
?>  
</BODY></HTML>