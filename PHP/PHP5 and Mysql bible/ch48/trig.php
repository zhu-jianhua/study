<?php 

function angle_given_sides ($opposite, $other_1, $other_2) {
   if (($opposite <= 0) || 
       ($other_1 <= 0) || 
       ($other_2 <= 0) ||
       ($opposite >= ($other_1 + $other_2)) ||
       ($other_1 >= ($opposite + $other_2)) ||
       ($other_2 >= ($other_1 + $opposite))) {
     die("Triangle with impossible side lengths in ".
         "angle_given_sides: $opposite, $other_1, $other_2");
   }
   else { 
     $numerator = 
       ((($other_1 * $other_1) +
          ($other_2 * $other_2)) -
         ($opposite * $opposite));
     $denominator = 2 * $other_1 * $other_2;
     return(acos($numerator / $denominator));
  }
}

function area_to_radius ($area) {
  return (sqrt ($area / M_PI));
}

function circle_intersection_area ($radius_left,
                                   $radius_right, 
                                   $distance) {
  if ($radius_right + $radius_left <= $distance) {
    return(0);
  }
  else {
    // first, we find the angle measures of a triangle
    //   formed by the two radii and the distance
    //   between them
    $left_sector_angle = 
      angle_given_sides($radius_right, $radius_left,
                        $distance);
    $right_sector_angle = 
      angle_given_sides($radius_left, $radius_right,
                        $distance);

    // test for obtuseness --- the sector angle can
    // be obtuse, but the triangle angle should not
    // be.  Also save the result as a sign for the
    // eventual area calculation

    if ($left_sector_angle < M_PI / 2) {
      $left_triangle_angle = $left_sector_angle;
      $left_triangle_sign = 1;
    }
    else {
      $left_triangle_angle = M_PI - $left_sector_angle;
      $left_triangle_sign = -1;
    }
    if ($right_sector_angle < M_PI / 2) {
      $right_triangle_angle = $right_sector_angle;
      $right_triangle_sign = 1;
    }
    else {
      $right_triangle_angle = M_PI - $right_sector_angle;
      $right_triangle_sign = -1;
    }

    // next, find the height of that triangle, assuming
    //  the distance is the base

    $height = ($radius_left / sin(M_PI_2)) *
              sin($left_triangle_angle);
    $base_left = ($radius_left / sin(M_PI_2)) *
                  sin(M_PI_2 - $left_triangle_angle);
    $base_right = ($radius_right / sin(M_PI_2)) *
                  sin(M_PI_2 - $right_triangle_angle);

    // finally find triangle and sector areas, and 
    // subtract (or add) appropriately to get the 
    // intersection area.  Multiply by 2 to reflect 
    // areas on both sides of the segment connecting
    // the circle centers

    $left_triangle_area = $base_left * $height / 2;
    $right_triangle_area = $base_right * $height / 2;
    $left_sector_area = 
       ($left_sector_angle / (2 * M_PI)) *
       (M_PI * $radius_left * $radius_left);
    $right_sector_area = 
       ($right_sector_angle / (2 * M_PI)) *
       (M_PI * $radius_right * $radius_right);

    $intersection_area = 2 *
       (($left_sector_area - 
           ($left_triangle_sign * $left_triangle_area)) +
        ($right_sector_area - 
           ($right_triangle_sign * $right_triangle_area)));

    return($intersection_area);
  }
}

?>
