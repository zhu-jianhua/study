<HTML>
<HEAD>
<TITLE>Make-a-poll</TITLE>
</HEAD>

<BODY>
<CENTER><H3>Make-a-poll</H3></CENTER>

<P>Use this form to define a poll:</P>
<FORM METHOD="post" ACTION="writepoll.php">

<P>Give this poll a <B>short</B> name, like <FONT COLOR="red">Color Poll</FONT>.<BR>
<INPUT TYPE=TEXT NAME="PollName" SIZE=30>
</P>

<P>This poll should <B>begin</B> on this date (MM/DD/YYYY):
<INPUT TYPE=TEXT Name="Poll_Startdate" SIZE=10>
</P>

<P>This poll should <B>end</B> on this date (MM/DD/YYYY):
<INPUT TYPE=TEXT NAME="Poll_Enddate" SIZE=10>
</P>

<P>This is the poll question (<FONT COLOR="blue">e.g. Why did the chicken cross the road?</FONT>):
<INPUT TYPE=TEXT NAME="Poll_Question", size=100>
</P>

<P>These are the potential answer choices you want to offer (<FONT COLOR="darkgreen">e.g. Yes, No, Say what?</FONT>).  Fill in only as many as you need.  Keep in mind that brevity is the soul of good poll-making.<BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
<INPUT TYPE=TEXT NAME="Raw_Poll_Option[]" SIZE=25><BR>
</P>

<INPUT TYPE="submit" NAME="Submit" VALUE="Add a poll">
</FORM>
 
</BODY>
</HTML>
