<!-- Listing 47-4:  Book page template (review.php) -->
<?php

/********************
* Book review page. *
*********************/

// For now, pass in the id in the URI
$book_id = $_GET['book_id'];
if !isSet($book_id) || !isNumeric($book_id) {
  echo "You did not pass in a valid book ID";
  exit;
}

// ------------
// GET THE DATA
// ------------
$db = mysql_connect('localhost', 'mg_user', 'sesame');
mysql_select_db('mg');
// Book data
$query = "SELECT
            B_id,
            B_title, 
            B_year,
            B_rating,
            B_movie,
            B_awards,
            B_review, 
            B_similar
          FROM book
          WHERE B_id = $book_id";
$result = mysql_query($query);
if (mysql_num_rows($result) == 1) {
  $book_arr = mysql_fetch_array($result);
} else {
  echo mysql_error();
}
$title = stripslashes($book_arr['B_title']);
$year = $book_arr['B_year'];
$rating = $book_arr['B_rating'];
$movie = stripslashes($book_arr['B_movie']);
$awards = stripslashes($book_arr['B_awards']);
$review = stripslashes($book_arr['B_review']);
$review_words = explode(" ", $review);
$chunk = array_slice($review_words, 0, 200);
$review = implode(' ', $chunk);
$similar = stripslashes($book_arr['B_similar']);

// Author data
$query = "SELECT author.A_id, author.A_firstname, author.A_lastname
          FROM author LEFT JOIN book_author USING (A_id)
          WHERE book_author.B_id = $book_id";
$result = mysql_query($query);
if (mysql_num_rows($result) == 1) {
  $author_arr = mysql_fetch_array($result);
  $author_id = $author_arr['A_id']; 
  $a_firstname = stripslashes($author_arr['A_firstname']);
  $a_lastname = stripslashes($author_arr['A_lastname']);
  $author = "$a_firstname $a_lastname";
} else {
  echo mysql_error();
}

// Potential multiple other books by the same author
$query = "SELECT book.B_title
          FROM book LEFT JOIN book_author USING (B_id)
          WHERE book_author.A_id = $author_id
          AND book.B_id != $book_id";
$result = mysql_query($query); 
if (mysql_num_rows($result) >= 1) {
  while ($titles_arr = mysql_fetch_array($result)) {
    $titles[] = stripslashes($titles_arr['B_title']);
  }
  $title_str = implode('<BR>\n', $titles);
} else {
  $title_str = 'None';
}

// Protagonist data
$query = "SELECT protagonist.P_firstname, protagonist.P_lastname
          FROM protagonist LEFT JOIN book_protagonist USING (P_id)
          WHERE book_protagonist.B_id = $book_id";
$result = mysql_query($query);
if (mysql_num_rows($result) == 1) {
  $prot_arr = mysql_fetch_array($result);
  $p_firstname = stripslashes($prot_arr['P_firstname']);
  $p_lastname = stripslashes($prot_arr['P_lastname']);
  $protagonist = "$p_firstname $p_lastname";
} else {
  echo mysql_error();
}

// Multiple subgenres
$query = "SELECT Sub_name
          FROM subgenre LEFT JOIN book_subgenre USING (Sub_id)
          WHERE book_subgenre.B_id = $book_id";
$result = mysql_query($query);
if (mysql_num_rows($result) >= 1) {
  while ($sub_arr = mysql_fetch_array($result)) {
    $sub_name[] = stripslashes($sub_arr['Sub_name']);
  }
  $subgenre = implode(', ', $sub_name);
} else {
  echo mysql_error();
}

// Multiple settings
$query = "SELECT Set_name
          FROM setting LEFT JOIN book_setting USING (Set_id)
          WHERE book_setting.B_id = $book_id";
$result = mysql_query($query);
if (mysql_num_rows($result) >= 1) {
  while ($set_arr = mysql_fetch_array($result)) {
    $set_name[] = stripslashes($set_arr['Set_name']);
  }
  $setting = implode(', ', $set_name);
} else {
  echo mysql_error();
}
// ------------
// DISPLAY PAGE
// ------------
$php_self = $_SERVER['PHP_SELF']; //Superglobal arrays don't work with heredoc
$page_str = <<< EOPAGESTR

<HTML>
<HEAD>
<STYLE>
TD.textblock {
  padding-left: 20;
  padding-top: 20;
  padding-right: 20;
}
P.td {
  font-family: arial, verdana, sans-serif;
  font-size: 8pt;
}
P.td_med {
  font-family: arial, verdana, sans-serif;
  font-size: 10pt;
  line-height:125%
}
P.title {
  font-family: arial, verdana, sans-serif;
  font-size: 10pt;
  font-weight: bold;
}
P.tab_links {
  font-family: arial, verdana, sans-serif;
  font-size: 10pt;
  margin-top: 17; 
}
a {
  color:#006400;
  text-decoration:none;
  }
a:link {color:#006400;} 
a:visited {color:#800080;}
</STYLE>
</HEAD>

<BODY BACKGROUND="background.gif">

<!-- Begin main table -->
<TABLE BORDER=0 WIDTH=815>
<TR>
<TD>
  <IMG SRC="spacer.gif" WIDTH=815 HEIGHT=8>
</TD>
</TR>
<TR>
<TD>
  <!-- Begin banner table -->
  <TABLE BORDER=0>
  <TR>
  <TD WIDTH=48 HEIGHT=90>
    <IMG SRC="spacer.gif" WIDTH=48 HEIGHT=90>
  </TD>
  <TD WIDTH=472 HEIGHT=90 ALIGN="center" VALIGN="middle"">
     <IMG SRC="red.png" WIDTH=460 HEIGHT=60>
  </TD>
  <TD WIDTH=14 HEIGHT=90>
     <IMG SRC="spacer.gif" WIDTH=14 HEIGHT=90>
  </TD>
  <TD WIDTH=292 HEIGHT=90 VALIGN="top" class="textblock">
    <P class="td">a Troutworks, Inc. site<BR>
    &#169; 1994 - 1999 Troutworks, Inc.</P>
    <P class="td">Last updated July 6, 1999</P>
  </TD>
  </TR>
  </TABLE>
  <!-- End banner table -->
</TD>
</TR>
<TR>
<TD>
  <!-- Begin title table -->
  <TABLE BORDER=0>
  <TR>
  <TD WIDTH=140 HEIGHT=30>
    <IMG SRC="spacer.gif" WIDTH=140 HEIGHT=30>
  </TD>
  <TD WIDTH=330 HEIGHT=30 ALIGN="center" VALIGN="bottom">
    <P class="title">$title</P>
  </TD>
  <TD WIDTH=345 HEIGHT=30>
    <IMG SRC="spacer.gif" WIDTH=345 HEIGHT=30>
  </TD>
  </TR>
  </TABLE>
  <!-- End title table -->
</TD>
</TR>
<TR>
<TD>
  <!-- Begin info table -->
  <TABLE BORDER=0>
  <TR>
  <TD WIDTH=135 HEIGHT=350 ROWSPAN=2 ALIGN="left" VALIGN="top" style="padding-left:22; padding-top:40">
    <P class="td">
    <A HREF="newbooks.html">New Reviews</A><BR>
    <A HREF="readerratings.html">Reader ratings</A></P>

    <P class="td">
    GENRES<BR>
    <A HREF="caper.html">Caper</A><BR>
    <A HREF="classic-whodunit.html">Classic whodunit</A><BR>
    <A HREF="cozy.html">Cozy</A><BR>
    <A HREF="espionage.html">Espionage</A><BR>
    <A HREF="forensic.html">Forensic</A><BR>
    <A HREF="hard-boiled.html">Hard-boiled</A><BR>
    <A HREF="historical.html">Historical</A><BR>
    <A HREF="legal.html">Legal</A><BR>
    <A HREF="military.html">Military</A><BR>
    <A HREF="police-procedural.html">Police procedural</A><BR>
    <A HREF="political.html">Political</A><BR>
    <A HREF="private-eye.html">Private eye</A><BR>
    <A HREF="serial-killer.html">Serial killer</A><BR>
    <A HREF="sf-mystery.html">SF mystery</A><BR>
    <A HREF="special-subject.html">Special subject</A><BR>
    <A HREF="suspense.html">Suspense</A><BR>
    <A HREF="thriller.html">Thriller</A></P>
  </TD>
  <TD WIDTH=15 HEIGHT=350 ROWSPAN=2>
    <IMG SRC="spacer.gif" WIDTH=15 HEIGHT=350>
  </TD>
  <TD>
    <TABLE BORDER=0 WIDTH=665>
    <TR>
    <TD WIDTH=350 HEIGHT=240 ALIGN="left" VALIGN="top" style="padding-left:11">
      <P class="tab_links">Read Reviews</P>
      <P class="tab_links">Browse by:&nbsp;&nbsp;&nbsp; Genre    |    <A HREF="authorlist.html">Author</A>    |    <A HREF="authorlist.html">Title</A>   |    <A HREF="readerratings.html">Ratings</A></P>
      <P class="tab_links">Author:  $author<BR>
      Protagonist name:  $protagonist<BR>
      Year published:  $year<BR>
      Subgenres:  $subgenre<BR>
      Setting:  $setting</P>
    </TD>
    <TD WIDTH=334 HEIGHT=240 ALIGN="left" VALIGN="top" style="padding-left:13">
      <P class="td"><B>Other Reviewed Titles By This Author</B><BR>$title_str
      </P>
      <P class="td"><B>Top 5 Most Similar Titles</B><BR>$similar
      </P>
      <P class="td"><B>Movie versions</B><BR>$movie</P>
    </TD>
    </TR>
    </TABLE>
  </TD>
  </TR>
  <TR>
  <TD WIDTH=665 HEIGHT=100>
    <TABLE BORDER=0 WIDTH=665>
    <TR>
    <TD WIDTH=250 HEIGHT=100 ALIGN="left" VALIGN="top" style="padding-left:13">
      <P class="title">Our rating:  $rating
      <BR>Community rating:  $comm_rating</P>
      <P class="td_med"><B>Awards:</B>  $award</P>
    </TD>
    <TD WIDTH=415 HEIGHT=100 ALIGN="left" VALIGN="top" style="padding-left:40; padding-top:7">
      <IMG SRC="red.png" WIDTH=350 HEIGHT=80>
    </TD>
    </TR>
    </TABLE>
  </TD>
  </TR>
  </TABLE>
  <!-- End info table -->
</TD>
</TR>
<TR>
<TD>
  <!-- Begin review table -->
  <TABLE BORDER=0>
  <TR>
  <TD WIDTH=40 HEIGHT=250>
    <IMG SRC="spacer.gif" WIDTH=40 HEIGHT=250>
  </TD>
  <TD WIDTH=560 HEIGHT=250 class="textblock">
    <P CLASS="td_med">$review <A HREF="$php_self?format=review_only">...READ COMPLETE REVIEW...</A></P>
  </TD>
  <TD WIDTH=155 HEIGHT=250 ALIGN="left" VALIGN="top" style="padding-left:10; padding-top:5">
    <P class="title">What did YOU think?</P>
    <P class="td">Read this book?  Rate it!</P>
    <FORM><INPUT TYPE="submit" VALUE="5 - Superb"></FORM>
    <FORM><INPUT TYPE="submit" VALUE="4 - Very Good"></FORM>
    <FORM><INPUT TYPE="submit" VALUE="3 - Good"></FORM>
    <FORM><INPUT TYPE="submit" VALUE="2 - Mediocre"></FORM>
    <FORM><INPUT TYPE="submit" VALUE="1 - Poor">
  </TD>
  <TD WIDTH=40 HEIGHT=250>
    <IMG SRC="spacer.gif" WIDTH=40 HEIGHT=260>
  </TD>
  </TR>
  </TABLE>
  <!-- End review table -->
</TD>
</TR>
<TR>
<TD>
  <!-- Begin credits table -->
  <TABLE BORDER=0 HEIGHT=65>
  <TR>
  <TD WIDTH=25>
    <IMG SRC="spacer.gif" WIDTH=25 HEIGHT=65>
  </TD>
  <TD WIDTH=790 HEIGHT=65 VALIGN="bottom" style="padding-left:25;padding-bottom:28">
    <P class="td">FAQs  |  Team Trout  |  Privacy  |  Advertising  |  Email Us</P>
  </TD>
  </TR>
  </TABLE>
  <!-- End credits table -->
</TD>
</TR>
</TABLE>
<!-- End main table -->
</BODY>
</HTML>
EOPAGESTR;
echo $page_str;
?>
