<?php
// Create a 200x100 image

$canvas = imagecreatetruecolor(300,300);

$white = imagecolorallocate($canvas, 255,255,255);
$black = imagecolorallocate($canvas,0,0,0);
imageline($canvas,0,0,300,300,$white);

imagepng($canvas, "j.png");
imagedestroy($canvas);

echo "<img src='j.png' />";

?>
