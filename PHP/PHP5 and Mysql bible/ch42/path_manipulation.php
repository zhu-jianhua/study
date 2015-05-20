<?php

include_once("path_display.php");

function spike ($path) {
  // Takes a path and returns a path
  $path_to_return = make_path();
  $prev_point = NULL;
  foreach ($path as $point) {
    if ($point && $prev_point) {
      $path_to_return = 
           add_point_to_path($path_to_return,
                             $prev_point);
      $path_to_return = 
          add_point_to_path($path_to_return,
             point_along_segment($prev_point,
                               $point,
                               0.25));
        $path_to_return = 
          add_point_to_path($path_to_return,
             point_off_segment($prev_point,
                               $point,
                               0.5, 0.23));
        $path_to_return = 
           add_point_to_path($path_to_return,
              point_along_segment($prev_point,
                               $point,
                               0.75));
        $path_to_return = 
           add_point_to_path($path_to_return,
                             $point);
    }
    $prev_point = $point;
  }
  return($path_to_return);
}

function top_hat ($path) {
  // Takes a path and returns a path
  $path_to_return = make_path();
  $prev_point = NULL;
  foreach ($path as $point) {
    if ($point && $prev_point) {
      $path_to_return = 
           add_point_to_path($path_to_return,
                             $prev_point);
      $path_to_return = 
          add_point_to_path($path_to_return,
             point_along_segment($prev_point,
                               $point,
                               0.35));
        $path_to_return = 
          add_point_to_path($path_to_return,
             point_off_segment($prev_point,
                               $point,
                               0.35, 0.24));
        $path_to_return = 
          add_point_to_path($path_to_return,
             point_off_segment($prev_point,
                               $point,
                               0.65, 0.24));
        $path_to_return = 
           add_point_to_path($path_to_return,
              point_along_segment($prev_point,
                               $point,
                               0.65));
        $path_to_return = 
           add_point_to_path($path_to_return,
                             $point);
    }
    $prev_point = $point;
  }
  return($path_to_return);
}



function point_along_segment ($first_point, 
                              $second_point,
                              $proportion) 
{
  $delta_x = (point_x($second_point) -
              point_x($first_point));
  $delta_y = (point_y($second_point) -
              point_y($first_point));
  return(make_point(point_x($first_point) +
                    $proportion * $delta_x,
                    point_y($first_point) +
                    $proportion * $delta_y));
}

function point_off_segment ($first_point, 
                            $second_point,
                            $proportion,
                            $proportional_distance) 
{
  $delta_x = (point_x($second_point) -
              point_x($first_point));
  $delta_y = (point_y($second_point) -
              point_y($first_point));
  return(make_point(point_x($first_point) +
                    $proportion * $delta_x -
                    $proportional_distance *
                    $delta_y,
                    point_y($first_point) +
                    $proportion * $delta_y +
                    $proportional_distance *
                    $delta_x));
}

function make_small_rectangle () {
  $path = make_path();
  $path = add_point_to_path ($path, make_point(75, 275));
  $path = add_point_to_path ($path, make_point(375, 275));
  $path = add_point_to_path ($path, make_point(375, 125));
  $path = add_point_to_path ($path, make_point(75, 125));
  $path = add_point_to_path ($path, make_point(75, 275));
  return($path);
}

function make_large_rectangle () {
  $path = make_path();
  $path = add_point_to_path ($path, make_point(5, 5));
  $path = add_point_to_path ($path, make_point(495, 5));
  $path = add_point_to_path ($path, make_point(495, 395));
  $path = add_point_to_path ($path, make_point(5, 395));
  $path = add_point_to_path ($path, make_point(5, 5));
  return($path);
}

?>
