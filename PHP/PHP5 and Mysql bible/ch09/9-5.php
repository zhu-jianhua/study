<!-- Listing 9-5: Entry form for multidimensional arrays -->
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
<H1>Workout calculator (multidimensional arrays)</H1>
<P>Select one or more of the following exercises, and we'll tell you<BR> 
how long you'd have to do each one to burn one pound of fat.</P>

<FORM METHOD="post" ACTION="wc_handler_mult_arr.php">
<table>
<tr>
  <td><B>Aerobic exercise</B></td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[0][0]" 
       value="1">&nbsp;Biking/cycling</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[0][1]" 
       value="1">&nbsp;Rowing</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[0][2]" 
       value="1">&nbsp;Running</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[0][3]" 
       value="1">&nbsp;Stairclimber</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[0][4]" 
       value="1">&nbsp;Walking</td>
</tr>
<tr>
  <td><B>Sports</B></td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[1][0]" 
       value="1">&nbsp;Basketball</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[1][1]" 
       value="1">&nbsp;Ice hockey</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[1][2]" 
       value="1">&nbsp;Soccer/football</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[1][3]" 
       value="1">&nbsp;Table tennis</td>
</tr>
<tr>
  <td><B>Strength training</B></td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[2][0]" 
       value="1">&nbsp;Calisthenics</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[2][1]" 
       value="1">&nbsp;Weightlifting (light)</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[2][2]" 
       value="1">&nbsp;Weightlifting (strenuous)</td>
</tr>
<tr>
  <td><B>Stretching/flexibility</B></td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[3][0]" 
       value="1">&nbsp;Pilates</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[3][1]" 
       value="1">&nbsp;Tai chi</td>
</tr>
<tr>
  <td><input type="checkbox" name="exercise[3][2]" 
       value="1">&nbsp;Yoga</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" name="submit" 
       value="Burn, baby, burn!"></td>
</td></tr>
</table>
</TR>
</TABLE>
</FORM>

</BODY>
</HTML>

