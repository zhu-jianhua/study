<!-- Listing 37-4: Send e-email with a text attachment (send_license.php) -->
<?php

/**************************************************************
* This file initially shows a form to input an email address. *
* Once submitted, it sends e-mail with a license file attached.*
* The text of the e-mail is contained in a text file named     * 
* license_mail.txt.                                           *
**************************************************************/
if ($_POST['submit'] == 'Send my license!') {
  // Make sure it's not some kind of attack
  if (strlen($_POST['email']) > 40) {
    echo 'Bad string';
    exit;
  }

  include('class.html.mime.mail.inc');

		$mail = new html_mime_mail(array('X-Mailer: Html Mime Mail Class'));
		$attachment = $mail->get_file('eval_license.lic');
		$mailbody = $mail->get_file('license_email.txt');

		$mail->add_text($mailbody);
		$mail->add_attachment($attachment, 'eval_license.lic', 'text/plain');
		$mail->build_message();
		$mail->send('Evaluator', $_POST['email'], 'mailbot@example.com', 'mailbot@example.com', 'Evaluation license');
} else {
  $form_str = <<< EOFORM
<HTML>
<BODY>
<FORM METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="text" NAME="email" SIZE=25>
<INPUT TYPE="submit" NAME="submit" VALUE="Send my license!">
</FORM>
</BODY>
</HTML>
EOFORM;

  echo $form_str;
}
?>

