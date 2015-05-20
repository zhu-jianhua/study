<!-- Listing 47-2: Script to dump data ino MySQL (dumpdata.php) -->
<?php

/*********************************************
 * Script to dump data into the MG database. *
 *********************************************/


// Read in the file as an array
// ----------------------------
$filename = 'tabdelimitedfile.txt';
$farray = file($filename) or die("Can't read in file");


// Open up a database connection
$db = mysql_connect('localhost', 'editor', 'sesame') or die("Can't connect to the database");
mysql_select_db('mg');


// Loop through each entry
// -----------------------
foreach ($farray as $val) {
  $l_arr = explode("\t", $val);
  print_r($l_arr); 

  // Tidy up the entries
  // -------------------

  // Author info
  $Author = $l_arr[1]; 
  // Divide name into first and last
  $A_array = explode(', ', $Author);
  $A_firstname = addslashes($A_array[1]);
  $A_lastname = addslashes($A_array[0]);
  $A_gender = addslashes($l_arr[2]);
  if ($A_gender == 'F') {
    $A_gender = 0; 
  } elseif ($A_gender == 'M') {
    $A_gender = 1;
  } else {
    echo "$A_firstname $A_lastname has gender issues";
  }
  $A_nationality = addslashes($l_arr[3]);
  $A_interview = addslashes($l_arr[31]);
  // Book info
  $B_title = addslashes($l_arr[0]);
  $B_year = $l_arr[4];
  $B_rating = $l_arr[10];
  $B_action = $l_arr[17];
  $B_humor = $l_arr[18];
  $B_romance = $l_arr[19];
  $B_sex = $l_arr[20];
  $B_violence = $l_arr[21];
  $B_reviewer = addslashes($l_arr[23]);
  $B_pages = $l_arr[24]; 
  $B_reviewdate = $l_arr[25];
  // Reformat the review date from m/d/yy to yyyy-mm-dd
  $date_arr = explode('/', $B_reviewdate);
  $B_reviewdate = date('Y-m-d', mktime(12, 30, 0, $date_arr[0], $date_arr[1], $date_arr[2]));
  $B_ISBN = $l_arr[26];
  $B_movie = addslashes($l_arr[27]); 
  $B_awards = addslashes($l_arr[28]);
  $B_review = addslashes($l_arr[29]);
  $B_blurb = addslashes($l_arr[30]);

  // Subgenre info
  $Subgenre[1] = addslashes($l_arr[5]);
  $Subgenre[2] = addslashes($l_arr[6]);
  $Subgenre[3] = addslashes($l_arr[7]); 


  // Enter data into database
  // ------------------------

  // Author data
  // First see if this author is already in the database
  $query = "SELECT A_id FROM author
            WHERE A_firstname = '$A_firstname'
            AND A_lastname = '$A_lastname'
            ";
  $result = mysql_query($query);
  if (mysql_num_rows($result) == 0) {
    // If not already there, add the author
    $query = "INSERT INTO author VALUES(
             NULL,
             '$A_firstname',
             '$A_lastname',
             $A_gender, 
             '$A_nationality',
             '$A_interview'
             )";
    $result = mysql_query($query);
    if (mysql_affected_rows() != 1) {
          echo "Problem inserting author data for $A_firstname $A_lastname";
    } else {
      $author_id = mysql_insert_id(); //Need this for book_author
    }
  } else {
    $author_id = mysql_result($result, 0, 0);
  }

  // Book data
  // We can assume each book is unique
  $query = "INSERT INTO book VALUES(
            NULL,
            '$B_title',
            '$B_year',
            $B_rating,
            $B_action,
            $B_humor,
            $B_romance,
            $B_sex,
            $B_violence,
            '$B_reviewer',
            $B_pages,
            '$B_reviewdate',
            '$B_ISBN',
            '$B_movie',             
            '$B_awards',
            '$B_review',
            '$B_blurb'
            )";
  $result = mysql_query($query);
  $book_id = mysql_insert_id(); //Need this for book_author
  if (!$book_id || $book_id == "") {
    echo "Problem inserting book data for $B_title";
  }

  // Associate book and author
  $query = "INSERT INTO book_author VALUES(
            NULL,
            $book_id,
            $author_id
           )"; 
  $result = mysql_query($query);
  if (mysql_affected_rows() != 1) {
    echo "Problem inserting book_author data for $B_title";
  }

  // Subgenres
  for ($i = 1; $i <= 3; $i++) {
    if ($Subgenre[$i] == "") {
      continue;
    } else {
      // First see if this subgenre is already in the database
      $query = "SELECT Sub_id FROM subgenre
                WHERE Sub_name = '$Subgenre[$i]'
                ";
      $result = mysql_query($query);
      if (mysql_num_rows($result) == 0) {
        // If not already there, add the subgenre
        $query = "INSERT INTO subgenre VALUES(
                  NULL, 
                  '$Subgenre[$i]'
                 )";
        $result = mysql_query($query);
        if (mysql_affected_rows() != 1) {
          echo "Problem inserting subgenre $Subgenre[$i]";
        } else {
          $subgenre_id = mysql_insert_id();
        }
      } else {
        $subgenre_id = mysql_result($result, 0, 0);
      }

      // Now associate the subgenre with the book
      $query = "INSERT INTO book_subgenre VALUES(
                NULL, 
                $book_id,
                $subgenre_id
               )";
      $result = mysql_query($query);
      if (mysql_affected_rows() != 1) {
        echo "Problem inserting book_subgenre data for $B_title and $Subgenre[$i]";
      }
    }
  }

}

?>
