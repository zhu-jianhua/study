<!-- Listing 47-3: Script to harvest data from HTML files (harvest.php) -->
<?php
// harvest.php - get movie information from a MysteryGuide HTML file

$file = 'sample_HTML_for_harvesting.html';
$fp = fopen($file, "r");
$file_str = fread($fp, filesize($file));

// Divide the page into chunks corresponding to tables
$tables = explode('</td></tr></table>', $file_str);

// Not every page will have all tables, so we need to
// rename our array in a more informative way.  If all your
// pages have all identical sections, you don't need to do this.
foreach ($tables as $table_val) {
  if (strpos($table_val, 'SIZE=+3') > 30) {
    $chunk['review'] = $table_val;
  } elseif (strpos($table_val, '<b>Further reading</b>') > 1) {
    $chunk['further'] = $table_val;
  }  elseif (strpos($table_val, '<b>Summary information</b>') > 1) {
    $chunk['summary'] = $table_val;
  }  elseif (strpos($table_val, '<b>Top 5') > 1) {
    $chunk['top5'] = $table_val;
  }  elseif (strpos($table_val, '<b>By the same') > 1) {
    $chunk['sameauthor'] = $table_val;
  }  elseif (strpos($table_val, '<b>Movies</b>') > 1) {
    $chunk['movie'] = $table_val;
  }
}


// Now we'll get the movie information
if (isSet($chunk['movie'])) {
  // Get everything after the word "Movies"
  $movie_str = strstr($chunk['movie'], 'Movies');

  // Now get the actual string value of the movie data
  $movie_data_str = strstr($movie_str, '<font SIZE=-2 FACE="ARIAL, GENEVA, SANS-SERIF">');
  $movie_data = substr($movie_data_str, 47); //get rid of the font tag above
  //echo $movie_data;

  // Now you can escape this string and put it in a database or whatever...
}

?>
