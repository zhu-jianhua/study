<!-- Listing 8-1: Exercise Calculator - The entry form -->
<HTML>
<HEAD>
<STYLE TYPE="text/css">
<!--
BODY, P {color: black; font-family: verdana; font-size: 10 pt}
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
<H1>Workout calculator (passing a string)</H1>
<P>Enter an exercise, and we'll tell you how long you'd have to do it<BR>to burn one pound of fat.</P>
<FORM METHOD="post" ACTION="wc_handler_str.php">
<INPUT TYPE="text" SIZE=50 NAME="exercise">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Burn, baby, burn!">
</FORM>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>

