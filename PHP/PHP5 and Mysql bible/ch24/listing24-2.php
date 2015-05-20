<?php
session_start();
session_register('visit_count');
?>

<HTML><HEAD><TITLE>Greetings</TITLE></HEAD>
<BODY>
<H2>Welcome to the Center for Content-free Hospitality</H2>
<?php
if (!IsSet($visit_count)) {
  echo print("Hello, you must have just arrived.  Welcome!<BR>");
  $visit_count = 1;
}
else {
  $visit_count++;
  echo print("Back again are ya?  That makes $visit_count times now ".
        "(not that anyone's counting)<BR>");
}

$self_url = $PHP_SELF;
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