<!-- Listing 37-5: Batch e-mail entry form (address_entry.php) -->
<HMTL>
<HEAD>
<TITLE>address_entry.php</TITLE>
</HEAD>

<BODY>
<CENTER><TABLE WIDTH=550><TR><TD>
Enter the names and e-mail addresses of recipients on this page. You do not have to complete all 25 entries. When you are ready to actually send the e-mails, click the Submit button at the bottom of the page.<BR><BR>
</TD></TR></TABLE></CENTER>

<FORM METHOD=post ACTION="email_send.php">
<?php
/* To keep the page sizes and mail batches to a manageable size, we will arbitrarily limit each batch to 25 names. If anything goes wrong -- the client accidentally closes the browser window before submitting, the PHP module isn't working, whatever -- the maximum number of entries that must be retyped is 25. To alter the batch size, change the number in the while loop below; and also in the form handling script. */


for ($batch_size = 0; $batch_size <= 25; $batch_size++) {
  print("<P>First name: <input type=\"text\" size=30 name=\"FirstName[]\"><BR>\nLast name: <input type=\"text\" size=30 name=\"LastName[]\"><BR>\nE-mail Address: <input type=\"text\" size=30 name=\"Email[]\"\n>");
}
?>
<BR><BR>
<P><INPUT TYPE="Submit" NAME="SUBMIT">
</FORM>
</BODY>
</HTML>


