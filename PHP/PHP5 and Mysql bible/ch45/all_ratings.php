<?php
include_once("db_connection.php");
include_once("rating_functions.php");
include_once("content_functions.php");

$query_best = 
  "select quotations.ID, 
          quotations.quotation, 
          quotations.attribution, 
          avg(rating_values.rank) as avg_rank
   from quotations, ratings, rating_values
   where ratings.rated_id = quotations.id
         and ratings.rating_id = rating_values.id
   group by quotations.id
   order by avg_rank desc limit 10";

$result = $db->query($query_best);

if (DB::isError($result)) 
  {
  $errorMessage = $result->getMessage();
  die ($errorMessage);
  }

$table_rows_string =
"<TR><TH>Quote</TH><TH>Attribution</TH><TH>Average rating</TH></TR>";

while ($row_array = $result->fetchRow()) 
  {
    $quotation_id = $row_array['ID'];
    $quotation_text = $row_array['quotation'];
    $truncated_quotation = truncate_quotation($quotation_text);
    $quotation_attribution = $row_array['attribution'];
    $avg_rank = $row_array['avg_rank'];
    $rounded_avg_rank = sprintf("%.1f", $avg_rank);
$table_rows_string .= 
    "<TR><TD><A HREF=\"rated_display.php?RATED_ID=$quotation_id\">
     $truncated_quotation</A></TD>
     <TD>$quotation_attribution</TD>".
    "<TD>$rounded_avg_rank</TD></TR>";
  }

$db->disconnect();

// lay out the page
$title = "Ratings page for quotes";
$page_string = <<<EOP
<HTML><HEAD></HEAD><BODY>
<CENTER><H2>$title</H2></CENTER>
<TABLE BORDER=1>
<H2>Top ten most popular quotes</H2>
$table_rows_string
</TABLE>
</BODY>
</HTML>
EOP;

echo $page_string;
?>
