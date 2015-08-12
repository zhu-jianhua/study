<?php
  $system = new Java('java.lang.System');
  $version = $system->getProperty('java.version');
  $os = $system->getProperty('os.name');
?>
<HTML>
<HEAD>
  <TITLE>Fun with Java and JSP</TITLE>
</HEAD>
<BODY>
<H3>We are running Java version <?php echo $version ?> on the 
<?php echo $os ?> platform, and it's working!</H3>
</BODY>
</HTML>
