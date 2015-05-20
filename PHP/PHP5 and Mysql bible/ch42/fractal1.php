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

$path = make_small_rectangle();
$path = transform_path($path, 'spike', 4);
display_path($image, $path, $drawing_color);

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>