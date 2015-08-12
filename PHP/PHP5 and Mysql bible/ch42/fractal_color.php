<?php
include_once("path_display.php");
include_once("path_transform.php");
include_once("path_manipulation.php");

$IMAGE_WIDTH = 500;
$IMAGE_HEIGHT = 400;

$image = imagecreate($IMAGE_WIDTH, $IMAGE_HEIGHT)
  or die("Could not create image");
$background_color = ImageColorAllocate($image, 255, 255, 255);
$drawing_color = ImageColorAllocate($image, 0, 0, 0);
$drawing_color2 = ImageColorAllocate($image, 255, 0, 0);
$drawing_color3 = ImageColorAllocate($image, 0, 255, 0);

function display_path_color ($image, $path, $color1, $color2, $color3) {
  static $line_count = 0;
  $prev_point = NULL;
  foreach ($path as $point) {
    if ($point && $prev_point) {
      $line_count++;
      if ($line_count % 3 == 0) {
	$color = $color1;
      }
      else if ($line_count % 3 == 1) {
	$color = $color2;
      }
      else {
        $color = $color3;
      }
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

$path = make_small_rectangle();
$path = transform_path($path, 'top_hat', 4);
display_path_color($image, $path, $drawing_color, $drawing_color2, 
                   $drawing_color3);

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
