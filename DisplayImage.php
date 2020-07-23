<?php
$path = $_GET['element'];

header('Content-type: image/png');
$img = imagecreatefrompng($path);
imagepng($img);
imagedestroy($img);