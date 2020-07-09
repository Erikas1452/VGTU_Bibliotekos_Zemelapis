<?php
class Map
{
    public function drawMap($image,$coordinates)
    {

        $size = count($coordinates);
        $img = imagecreatefromjpeg($image);
        $blue = imagecolorallocate($img,0,0,255);
        for($i = 0; $i < $size; $i+=4)
        {
            $this->placeMarker($img, $coordinates[$i],$coordinates[$i+1],$coordinates[$i+2],$coordinates[$i+3], $blue);
        }
        header('Content-type: image/jpeg');
        imagejpeg($img);
        imagedestroy($img);
    }

    private function placeMarker($img,$x1,$y1,$x2,$y2,$color)
    {
        imagefilledrectangle($img,$x1,$y1,$x2,$y2,$color);
    }
}
?>