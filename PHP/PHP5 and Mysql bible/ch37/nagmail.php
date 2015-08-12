<!-- Mail script for cron (nagmail.php) -->
<?php

/*********************************************************
* This script is intended to run once per day as a cron. *
* It will query the database and send nagmail to people  *
* who got evaluation licences 45 days before.            *
*********************************************************/

$db = mysql_connect("localhost", "root");
mysql_select_db("evaluators");

// Format date for query
// Actually the afternoon of 46 days ago
$now = time();
$fortyfive_days_ago = $now - 3888000 - 43200;

$target_date = date('Y-m-d', $fortyfive_days_ago);
$send_info_email_arr = array();

$query = "SELECT email
          FROM sent_licenses
          WHERE sent_date >= '$target_date 00:00:00'
          AND sent_date <= '$target_date 23:59:59'
         ";
$result = mysql_query($query,$db);
if (mysql_num_rows($result) > 0) {
  while ($email_arr = mysql_fetch_array($result)) {
    $to = $email_arr[0];
    $from = 'mailbot@example.com';
    $subject = 'Evaluation software license expires';
    $msg     =  'You downloaded our evaluation software 45 days ago.  Now you should pay us, or it will self-destruct.';
    $mailsend = mail($to, $subject, $msg, "From: $from");
    $send_info_email_arr .= "\n".$to."\n";
  }

  // Send me some email to let me know what happened
  $info_msg .= "I sent mail to the following evaluators today:<BR><BR>\n";
  $info_msg .= print_r($send_info_email_arr);
  $info_mail = mail('webdev@example.com', "Cron job for $target_date", $info_msg, "From: cronjob@example.com");

} else {
  // If there were no recipients today, let me know that
  $info_msg = "I didn't find anyone to send mail to today.";
  $info_mail = mail('webdev@example.com', "Cron job for $target_date", $info_msg, "From: cronjob@example.com");

}
?>

