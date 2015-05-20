<?php

  $cr = new Java('java.lang.Calendar');

  $date_time = "yyyy-MM-dd HH:mm:ss";

  $date = new Java('java.text.SimpleDateFormat', $date_time);

  $current = date->format($cr->getTime());

?>

<HTML>
<HEAD>
  <TITLE>Got the time?</TITLE>
</HEAD>
<BODY>
<H3>The current date and time is: <?php echo $current ?>.</H3>
</BODY>
</HTML>
