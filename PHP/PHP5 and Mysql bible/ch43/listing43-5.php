<HTML>
<HEAD>
<TITLE>PHP4 Bible simple weblog:
<?php echo $_GET['date']; ?></TITLE>
<?php include("style.inc"); ?>
</HEAD>

<BODY BGCOLOR="#FFFFFF">
<TABLE BORDER="0" CELLPADDING="5" WIDTH="100%">
<!-- Title box -->
<TR WIDTH="100%" BGCOLOR="#822222">
  <TD WIDTH="100%" ALIGN="right" COLSPAN="2">
    <H1><?php echo $header_msg; ?></H1>
  </TD>
</TR>
<!-- End Title box -->

<!-- Begin main body -->
<TR WIDTH="100%">
  <TD WIDTH="20%" VALIGN="top" BGCOLOR="#FFFECC">
    <!-- Navbar -->
    <P CLASS="sidebar"><A HREF="weblog.php">Today</A></P>
    <P CLASS="sidebar"><A HREF="links.php">Links</A></P>
    <P CLASS="sidebar"><A HREF="favorites.php">Faves</A></P>
    <P CLASS="sidebar"><A HREF="aboutme.php">About me</A></P>
    <P CLASS="sidebar"><A
HREF="mailto:me@localhost">Contact</A></P>
    <!-- End Navbar -->
  </TD>
  <TD WIDTH="80%">