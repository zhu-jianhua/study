<!-- Listing 10-2: Form submission code for fitness calculator -->
<?php include_once("exercise_include.php");
?>
<html>
<head>
<style TYPE="text/css">
<!-
BODY, P, TD      {color: black; font-family: verdana; font-size: 10 pt}
H1        {color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</head>

<xbody>
<table BORDER=0 CELLPADDING=10 WIDTH=100%>
<tr>
<td BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=150>
</td>
<td BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<h1>Workout calculator (math)</h1>
<p>For one or more of the following exercises, enter<br> 
the duration in minutes and your current weight<br>
and we'll tell you how many calories you burned.</p>

<form METHOD="post" ACTION="wc_handler_math.php">
<table>
<tr>
  <td><input type="text" size=5 name="weight"><b>Weight (kilos)</b></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>

<?php 
$type_counter = 0;
foreach ($exercise_info 
           as $exercise_type => $per_exercise_info) {
  print("<tr><td><b>$exercise_type</b></td></tr>");
  $exercise_counter = 0;
  foreach ($per_exercise_info 
             as $exercise_name => $exercise_intensity) {
    print("<tr><td>
          <input type = \"text\" size = 5
            name=\"exercise[$type_counter][$exercise_counter]\"
          >&nbsp;$exercise_name</td></tr>");
    $exercise_counter++;
  }
  $type_counter++;
}
?>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" name="submit" 
       value="Burn, baby, burn!"></td>
</td></tr>
</table>
</tr>
</table>

</form>

</body>
</html>


