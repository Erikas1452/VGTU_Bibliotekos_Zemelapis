<?php
class Map
{
    public static function drawMap($image)
    {
        $img = imagecreatefromjpeg($image);
        $blue = imagecolorallocate($img,0,0,255);
        imagefilledrectangle($img,97,223,157,236, $blue);
        header('Content-type: image/jpeg');
        imagejpeg($img);
    }
}
?>