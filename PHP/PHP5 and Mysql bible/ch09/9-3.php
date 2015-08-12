<!-- Listing 9-3: Exercise Calculator - Entry form with check boxes -->
<HTML>
<HEAD>
<STYLE TYPE="text/css">
<!--
BODY, P, TD      {color: black; font-family: verdana; font-size: 10 pt}
H1        {color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</HEAD>

<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=150>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Workout calculator (multiple checkboxes with arrays)</H1>
<P>Select one or more of the following exercises, and we'll tell you<BR> how long you'd have to do each one to burn one pound of fat.</P>

<FORM METHOD="post" ACTION="wc_handler_array.php">
<table>
<tr>
  <td><input type="checkbox" name="exercise[0]" value="1">&nbsp;Biking/cycling</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[1]" value="1">&nbsp;Running</td>
</tr>
<tr><td><input type="checkbox" name="exercise[2]" value="1">&nbsp;Soccer/football</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[3]" value="1">&nbsp;Stairclimber</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[4]" value="1">&nbsp;Weightlifting</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" name="submit" value="Burn, baby, burn!"></td>

</TR>
</TABLE>
</FORM>

</TR></TABLE>

</BODY>
</HTML>

