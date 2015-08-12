<?php

$image = ImageCreateTruecolor(800,500) 
  or die("Could not create image");

for ($x = 0; $x < 50; $x++) {
    $red = (int)(rand()*255);	
    $green = (int)(rand()*255);	
    $blue = (int)(rand()*255);	
    $col = ImageColorAllocateAlpha($image,$red,$green,$blue,0);
    ImageFilledEllipse($image,50+$x*12,50+$x*7,50+$x*3,50+$x*3,$col);
}

header("Content-type: image/png");
ImagePng($image);
ImageDestroy($image);

?>
