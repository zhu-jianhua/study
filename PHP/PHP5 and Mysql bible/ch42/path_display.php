<?php

// --- points ----

// A point is just a pair of numerical coordinates

function make_point ($x, $y) {
  return(array($x, $y));
}

function point_x ($point) {
  return($point[0]);
}

function point_y ($point) {
  return($point[1]);
}

// --- paths ---

// A path is a list of points

function make_path () {
  return array();
}

function add_point_to_path ($path, $point) {
  $path[] = $point;
  return($path);
}

function display_path ($image, $path, $color) {
  static $line_count = 0;
  $prev_point = NULL;
  foreach ($path as $point) {
    if ($point && $prev_point) {
      $line_count++;
      imageline($image, 
                 point_x($prev_point),
                 point_y($prev_point),
                 point_x($point),
                 point_y($point),
                 $color);
    }
    $prev_point = $point;
  }
}
?>
