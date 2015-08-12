<!-- Listing 16-4: A complex display with a single query -->
<?php
include("/home/phpbook/phpbook-vars.inc");
/* open a single DB connection for this page */
$global_dbh = mysql_connect($hostname, $username, $password)
              or die("Could not connect to database");
mysql_select_db($db, $global_dbh)
              or die("Could not select database");

function display_cities($db_connection)
{
  /*  print table of countries and their cities,
      selectively printing only one HTML table row
      per country */
  $query = "select country.id,
                   country.continent, country.countryname,
                   city.cityname
                   from country, city
                   where country.id = city.countryID
                   order by country.continent,
                            country.countryname,
                            city.cityname";
  $result_id =
     mysql_query($query, $db_connection)
       OR die(mysql_error($query));

  /* begin table, print hard-coded table header */
  print("<TABLE BORDER=1>\n");
   print("<TH>Continent</TH><TH>Country</TH>
             <TH>Cities</TH></TR>");

  /* Initialize the ID for the "previous" country.
     We will rely on the fact that Country.ID is
     numbered beginning with 1, so a previous ID
     value of zero means that the current country
     is the first */
  $old_country_id = 0; 
  /* loop through result rows (one per city) */
  while ($row_array = mysql_fetch_row($result_id))
    {
      $country_id = $row_array[0];
      /* if we have a new country */
      if ($country_id != $old_country_id)
        {
          /* set up country info */
          $continent = $row_array[1];
          $country_name = $row_array[2];

          /* if there was a previous country
             close the city datum and country row */
          if ($old_country_id != 0)
            print("</TD></TR>\n");

          /* start a row for the new country,
             and begin the city table datum */
          print("<TR ALIGN=LEFT VALIGN=TOP>");
          print("<TD>$continent</TD>");
          print("<TD>$country_name</TD><TD>");

          /* the new country is no longer new */
          $old_country_id = $country_id;
        }
      /* the only thing that is printed for every result
         row is the name of a city */
      $city_name = $row_array[3];
      print("$city_name<BR>");
   }
  /* close off final country and table */
  print("</TD></TR></TABLE>");
}
?>
<HTML><HEAD><TITLE>Cities by Country</TITLE></HEAD>
<BODY>
<?php display_cities($global_dbh);
 ?>
</BODY></HTML>
