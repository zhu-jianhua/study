<?php


function transform_path ($path_input, 
                         $function_name,
                         $iterations) {
  // Expects a path, a path-to-path function
  //  and a number of times to apply the 
  //  function.
  // Returns a path
  $path_to_return = $path_input;
  for ($i = 0; $i < $iterations; $i++) {
    $path_to_return = $function_name($path_to_return);
  }
  return($path_to_return);
}



?>