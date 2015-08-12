<!-- Listing 6-1: A division table -->
<?php
  $start_num = 1;
  $end_num = 10;
?>
<HTML>
<HEAD>
<TITLE>A division table</TITLE>
</HEAD>
<BODY>
<H2>A division table</H2>
<TABLE BORDER=1>
<?php
  print("<TR>");
  print("<TH> </TH>");
  for ($count_1 = $start_num;
       $count_1 <= $end_num;
       $count_1++)
    print("<TH>$count_1</TH>");
  print("</TR>");

  for ($count_1 = $start_num;
       $count_1 <= $end_num;
       $count_1++)
  {
    print("<TR><TH>$count_1</TH>");
    for ($count_2 = $start_num;
         $count_2 <= $end_num;
         $count_2++)
      {
        $result = $count_1 / $count_2;
        printf("<TD>%.3f</TD>",
               $result);  // see Chapter 108
      }
    print("</TR>\n");
  }
?> 
</TABLE>
</BODY>
</HTML>

