<!-- Listing 16-5: Creating the sample tables -->
<?php
include("/home/phpbook/phpbook-vars.inc");
$global_dbh = mysql_connect($hostname, $username, $password)
              or die("Could not connect to database");
mysql_select_db($db, $global_dbh)
              or die ("Could not select databased");

function add_new_country($dbh, $continent, $countryname,
                           $city_array)

{
  $country_query =
    "insert into country (continent, countryname)
     values ('$continent', '$countryname')";
  $result_id =  mysql_query($country_query)
                OR die($country_query . mysql_error());
  if ($result_id)
    {
      $countryID = mysql_insert_id($dbh);   
      for ($city = current($city_array);
           $city;
           $city = next($city_array))
        {
           $city_query =
              "insert into city (countryID, cityname)
                      values ($countryID, '$city')";
           mysql_query($city_query, $dbh)
              OR die($city_query . mysql_error());
        }
    }
}

function populate_cities_db($dbh)
{
  /* drop tables if they exist -- permits function to be
     tried more than once */
  mysql_query("drop table city", $dbh);
  mysql_query("drop table country", $dbh);

  /* create the tables */
  mysql_query("create table country
               (ID int not null auto_increment primary key,
                continent varchar(50),
                countryname varchar(50))",
              $dbh)
              OR die(mysql_error());
  mysql_query("create table city
               (ID int not null auto_increment primary key,
                countryID int not null,
                cityname varchar(50))",
              $dbh)
              OR die(mysql_error());

  /* store data in the tables */
  add_new_country($dbh, 'Africa', 'Kenya',
            array('Nairobi','Mombasa','Meru'));
  add_new_country($dbh, 'South America', 'Brazil',
            array('Rio de Janeiro', 'Sao Paulo',
                     'Salvador', 'Belo Horizonte'));
  add_new_country($dbh, 'North America', 'USA',
            array('Chicago', 'New York', 'Houston', 'Miami'));
  add_new_country($dbh, 'North America', 'Canada',
            array('Montreal','Windsor','Winnipeg'));
 
  print("Sample database created<BR>");
}
?>

<HTML><HEAD><TITLE>Creating a sample database</TITLE></HEAD>
<BODY>
<?php populate_cities_db($global_dbh); ?>
</BODY></HTML>

