<!-- Listing 22-1: A print_links function -->
<?php

function print_links ($url) 
{
  $fp = fopen($url, "r")
    or die("Could not contact $url");
  $page_contents = "";
  while ($new_text = fread($fp, 100)) {
    $page_contents .= $new_text;
  }
  $match_result = 
    preg_match_all('/<\s*A\s*HREF="([^\"]+)"\s*>([^>]*)<\/A>/i',
               $page_contents,
               $match_array, 
               PREG_SET_ORDER);
  foreach ($match_array as $entry) {
    $href = $entry[1];
    $anchortext = $entry[2];
    print("<B>HREF</B>: $href; 
           <B>ANCHORTEXT</B>:  $anchortext<BR>");
  }
}

?>
