<?php

require_once('nusoap.php');
$s = new soap_server;
$s->register('getRecipe');

function getRecipe($recipe_name){
   $file = "$recipe_name.xml";
   $fp = fopen($file, 'r');
   $recipe_str = fread($fp, filesize($file));
   fclose($fp);
	// optionally catch an error and return a fault
	if($recipe_name == ''){
    	return new soap_fault('Client','','Must supply a valid recipe name.');
    }
	return $recipe_str;
}
$s->service($HTTP_RAW_POST_DATA);

?>