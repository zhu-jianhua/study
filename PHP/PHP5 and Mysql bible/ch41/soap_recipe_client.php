<?php

require_once('nusoap.php');

$recipe_name = $_GET['recipe'];
if ($recipe_name == '') {
  echo "You must supply a recipe name";
  exit;
}
$parameters = array('recipe'=>$recipe_name);
$soapclient = new soapclient('http://localhost/nusoap_server.php');
$result = $soapclient->call('getRecipe',$parameters);
//echo $result;


// Fire up Expat to make a shopping list
// -------------------------------------

$ingred_arr = array('types' => array(), 'values' => array());
$i = 0;
$e = -1;
// There is an element without a value, the recipe element
// so I'm jiggering this offset to match

function startElement($parser, $name, $attrs)
{
  global $ingred_arr, $e;
  if ($name != 'INGREDIENT' && $name != 'RECIPE_NAME' && $e > 0) {
    $ingred_arr[types][$e] = 1;
  }
  $e++;
}


function endElement($parser, $name)
{
  // Just need to define an endElement function for the parser
}


function characterData($parser, $value)
{
  global $ingred_arr, $i;
  if (strlen($value) > 1) {
    $ingred_arr[values][$i] = $value;
    $i++;
  }
}

// Run through the XML and stick the values in an array
// Also note if any of the elements are not recipe names or ingredient
$simpleparser = xml_parser_create();
xml_set_element_handler($simpleparser, "startElement", "endElement");
xml_set_character_data_handler($simpleparser, "characterData");

if (!xml_parse($simpleparser, $result, strlen($result))) {
  die(xml_error_string(xml_get_error_code($simpleparser)));
}
xml_parser_free($simpleparser);

// Get rid of any values that aren't ingredients or recipe name
foreach ($ingred_arr['values'] as $key=>$val) {
  if ($ingred_arr['types'][$key] == 1) {
    $ingred_arr['values'] = array_slice($ingred_arr['values'], 0, $key);
  }
}
$shopping_list = implode("\n", $ingred_arr['values']);

// Write it out to a file
$file = 'shoppinglist.txt';
$fp = fopen($file, "a+");
$write_int = fwrite($fp, $shopping_list);
fclose($fp);

// If you want, mail it to yourself instead
// mail('me@example.com', 'Shopping list', $shopping_list);

?>