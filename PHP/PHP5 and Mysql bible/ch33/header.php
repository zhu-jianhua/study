<!-- Listing 33-1: header.php -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php print($title); ?></title>
<meta name="Keywords" content="<?php print($keywords); ?>">
<meta name="Description" content="<?php echo($description); ?>">
</head>
<body>
<table cellpadding="0" cellspacing="0">
  <tr>
   <td colspan="2"><img src="<?php print "$banner_img" ?></td>
  </tr>
  <tr>
   <td valign="top">
     <?php include ($menu_file); ?>
   </td>
   <td valign="top">
