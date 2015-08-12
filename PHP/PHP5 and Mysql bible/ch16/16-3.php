<!-- Listing 16-3: A display with multiple queries -->
<?php
include("/home/phpbook/phpbook-vars.inc");
/* open database connection */
$global_dbh = mysql_connect($hostname, $username, $password)
              or die("Could not connect to database");
mysql_select_db($db, $global_dbh)
  or die("Could not select database");

function display_cities($db_connection)
{
  /* Displays table of cities and countries */
  $country_query = "select id, continent, countryname
                   from country
                   order by continent, countryname";
  $country_result =
     mysql_query($country_query, $db_connection);

  /* begin table, print hard-coded table header */
  print("<TABLE BORDER=1>\n");
  print("<TR><TH>Continent</TH><TH>Country</TH>
             <TH>Cities</TH></TR>");

  /* loop through countries */
  while ($country_row = mysql_fetch_row($country_result))
    {
      /* set up country info */
      $country_id = $country_row[0];
      $continent = $country_row[1];
      $country_name = $country_row[2];

      print("<TR ALIGN=LEFT VALIGN=TOP>");
      print("<TD>$continent</TD>");
      print("<TD>$country_name</TD>");

      /* begin table cell for city list */
      print("<TD>"); 
      $city_query = "select cityname from city
                     where countryID = $country_id
                     order by cityname";
      $city_result =
         mysql_query($city_query, $db_connection)
           OR die(mysql_error());
      /* loop through cities */
      while ($city_row = mysql_fetch_row($city_result))
        {
          $city_name = $city_row[0];
          print("$city_name<BR>");
        }
      /* close city cell and country row */
      print("</TD></TR>");
    }
  print("</TABLE>\n");
}
?>

<HTML>
<HEAD>
<TITLE>Cities by Country</TITLE>
</HEAD>
<BODY>
<?php
  display_cities($global_dbh);
?>
</BODY>
</HTML>
