<?php
$date = date("Ymd");
include("/home/htmluser/password.inc");

if($_POST['test_username'] == $username &&
  $_POST['test_password'] == $password) {
  $fp = fopen("/entries/$date.txt", "w");
  $try_entry = fwrite($fp, $_POST['logtext']);
  if ($try_entry > -1) {
    print("Weblog entry for $date written to disk.");
  } elseif ($try_entry == -1) {
    print("Weblog entry write failed.");
  }
} else {
  mail("me@localhost", "Weblog snoop alert", "Someone from
$REMOTE_ADDR is trying to get into your weblog entry
handler.");
}
?>