<?php
include_once("trig.php");

$IMAGE_WIDTH = 600;
$IMAGE_HEIGHT = 300;
$CENTER_FINDING_ITERATIONS = 20;

function imagecircle ($image, $center_x, $center_y,
 	              $radius, $color) 
{
  $diameter = $radius * 2;
  imagearc($image, $center_x, $center_y, 
	   $diameter, $diameter, 0, 360,
           $color);
}

function venn_visualization 
  ($left_amount, $left_name,
   $right_amount, $right_name, 
   $intersection_amount)
{
  global $IMAGE_HEIGHT, $IMAGE_WIDTH, 
         $CENTER_FINDING_ITERATIONS;
  // --- create the image and allocate colors
  $image = imagecreate($IMAGE_WIDTH, $IMAGE_HEIGHT)
    or die("Could not create image");
  $background_color = ImageColorAllocate($image, 255,255,255);
  $left_color = ImageColorAllocate($image, 100, 100, 200);
  $right_color = ImageColorAllocate($image, 200, 100, 100);
  $intersection_color = ImageColorAllocate($image, 225, 225, 225);
  $black_color = ImageColorAllocate($image, 0,0,0);

  // --- decide how big the circles should be
  $max_radius = min((($IMAGE_HEIGHT * 0.9) / 3),
	            (($IMAGE_WIDTH * 0.9) / 4));
  $center_y = $IMAGE_HEIGHT / 3.0;
  $default_center_x_left = $IMAGE_WIDTH / 4.0;
  $default_center_x_right = (3 * $IMAGE_WIDTH) / 4.0;
  $middle_x = $IMAGE_WIDTH / 2.0;
  $radius_left_side_raw =
    area_to_radius($left_amount);
  $radius_right_side_raw =
    area_to_radius($right_amount);
  $intersection_radius_raw = 
    area_to_radius($intersection_amount);
  $scale_factor = $max_radius /
                  (max($radius_left_side_raw,
                       $radius_right_side_raw));
  $radius_left_side = $radius_left_side_raw * $scale_factor;
  $radius_right_side = $radius_right_side_raw * $scale_factor;
  // (it's convenient to pretend that the intersection area
  //  has a radius (although it's not circular) just so we can
  //  calculate things the same way as the circles)
  $intersection_radius = $intersection_radius_raw * $scale_factor;
  $area_left_side = M_PI * 
                    $radius_left_side * $radius_left_side;
  $area_right_side = M_PI * 
                    $radius_right_side * $radius_right_side;
  $intersection_area = M_PI * 
                    $intersection_radius * $intersection_radius;

  // We now have all necessary info except where to locate the
  //  centers of the circles.
  // Four cases:  
  // 1) no intersection, 2) partial intersection
  // 3) left is strict subset of right, 
  // 4) right is subset of left.

  if ($intersection_amount == 0) {
    // No intersection
    $center_x_left = $default_center_x_left;
    $center_x_right = $default_center_x_right;
    $left_fill_x = $center_x_left;
    $right_fill_x = $center_x_right;
    $intersection_fill_x = -1;
  }
  else if (($intersection_area < $area_left_side) &&
           ($intersection_area < $area_right_side)) {

    // The complicated case --- we must decide where the
    //   circle centers should be so that the overlap is
    //   proportional to the set intersection
    // First, we call a function that decides how far apart
    //  the circle centers need to be.
    $center_distance = 
      find_center_distance($radius_left_side, $radius_right_side,
                           $intersection_area, 
                           $CENTER_FINDING_ITERATIONS);

    // Once we know the distance, we place the circle centers
    //  approximately in the middle of the image
    $center_x_left = $middle_x  // left/right middle of image
                     - ($center_distance *
                        ($radius_left_side / 
                          ($radius_left_side +
                            $radius_right_side)));
    $center_x_right = $middle_x  // left/right middle of image
                     + ($center_distance *
                        ($radius_right_side / 
                          ($radius_left_side +
                            $radius_right_side)));

    // we have decided the sizes and centers of the circles.
    //   Now, we must determine good points to start a 
    //   "flood fill" coloring of the three different regions
    $left_fill_x = 
      (($center_x_left - $radius_left_side) + 
       ($center_x_right - $radius_right_side)) 
      / 2.0;
    $right_fill_x = 
      (($center_x_left + $radius_left_side) + 
       ($center_x_right + $radius_right_side)) 
      / 2.0;
    $intersection_fill_x = 
       (($center_x_right - $radius_right_side) +
        ($center_x_left + $radius_left_side)) 
        / 2.0;
  }
  else if (($intersection_area == $area_left_side) &&
           ($intersection_area < $area_right_side)) {
    // The right set completely contains the left set
    //   We need to place the left circle somewhere 
    //   inside the right circle.
    $center_x_right = $middle_x;
    $center_x_left = $middle_x - 
       ($radius_right_side - $radius_left_side) / 2;
    $left_fill_x = -1;
    $right_fill_x = 
      (($center_x_left + $radius_left_side) + 
       ($center_x_right + $radius_right_side)) 
      / 2.0;
    $intersection_fill_x = $center_x_left;
  }
  else if ($intersection_area == $area_right_side) {
    $center_x_left = $middle_x;
    $center_x_right = $middle_x +
       ($radius_left_side - $radius_right_side) / 2;
    $right_fill_x = -1;
    $left_fill_x = 
      (($center_x_left - $radius_left_side) + 
       ($center_x_right - $radius_right_side)) 
      / 2.0;
    $intersection_fill_x = $center_x_right;
  }

  // now, actually draw and fill regions
  imagecircle($image, $center_x_left, $center_y,
              $radius_left_side, $black_color);             
  imagecircle($image, $center_x_right, $center_y,
            $radius_right_side, $black_color);             
  if ($left_fill_x > 0) {
    imagefill($image, $left_fill_x, 
              $center_y, $left_color);
  }
  if ($right_fill_x > 0) {  
    imagefill($image, $right_fill_x, 
              $center_y, $right_color);
  }
  if ($intersection_fill_x > 0 ) {
     imagefill($image, $intersection_fill_x, 
               $center_y, $intersection_color);
  }
  $left_hand_text = "$left_name ($left_amount)";
  $right_hand_text = "$right_name ($right_amount)";
  $intersection_text = "Intersection: $intersection_amount";
  left_label($image, $left_hand_text, $left_color);
  right_label($image, $right_hand_text, $right_color);
  intersection_label($image, $intersection_text, $black_color);
  
  // send off the image
  header("Content-type: image/png");
  imagepng($image);
  imagedestroy($image);
}

function left_label ($image, $label_string, $color) {
  global $IMAGE_WIDTH, $IMAGE_HEIGHT;
  imagestring($image, 5, 
              ($IMAGE_WIDTH / 4.0 -
                (imagefontwidth(5) * strlen($label_string))
                 / 2),
              $IMAGE_HEIGHT - 55.0,
              $label_string, $color);
}

function right_label ($image, $label_string, $color) {
  global $IMAGE_WIDTH, $IMAGE_HEIGHT;
  imagestring($image, 5, 
              ($IMAGE_WIDTH * 3 / 4.0 -
                (imagefontwidth(5) * strlen($label_string))
                 / 2),
              $IMAGE_HEIGHT - 55.0,
              $label_string, $color);  
}

function intersection_label ($image, $label_string, $color) {
  global $IMAGE_WIDTH, $IMAGE_HEIGHT;
  imagestring($image, 2, 
              ($IMAGE_WIDTH / 2.0  -
                (imagefontwidth(2) * strlen($label_string))
                 / 2),
              $IMAGE_HEIGHT - 30.0,
              $label_string, $color);
}

function find_center_distance ($r1, $r2, $desired_area,
                               $iterations) {
  // The greatest possible distance is r1 + r2, and
  //  the smallest is abs(r1 - r2) Let's start in the middle.
  $distance_guess = (($r1 + $r2) + abs($r1 - $r2)) / 2.0;
  $distance_increment = (($r1 + $r2) - abs($r1 - $r2)) / 4.0;
  for ($x = 0; $x < $iterations; $x++) {
    $calculated_area = 
      circle_intersection_area($r1, $r2, $distance_guess);
    if ($calculated_area < $desired_area) {
      // move centers closer
      $distance_guess -= $distance_increment;
      $distance_increment *= 0.5;
    }
    else if ($calculated_area > $desired_area) {
      // move centers apart
      $distance_guess += $distance_increment;
      $distance_increment *= 0.5;
    }
    else {
      // unlikely, but ya never know
      break;
    }
  }
  return($distance_guess);
}
?>
