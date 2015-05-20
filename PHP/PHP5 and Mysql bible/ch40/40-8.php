<?php 

$recipe = simplexml_load_file("recipe.xml"); 

$ingredients = $recipe->ingredients; 
$directions  = $recipe->directions; 
$servings    = $recipe->servings; 

foreach ($ingredients as $ingredient)
{
print "<P>Ingredient: $ingredient";
}

print "<P>Directions: $directions";
print "<P>Serves $servings";

?>
