<?php
class Map
{
    private $img;

    function __construct($image)
    {
        $this->img=imagecreatefromjpeg($image);
    }

    public function fillMap($coordinates)
    {
        $size = count($coordinates);
        $blue = imagecolorallocate($this->img,0,0,255);
        for($i = 0; $i < $size; $i+=4)
        {
            $this->placeMarker($this->img, $coordinates[$i],$coordinates[$i+1],$coordinates[$i+2],$coordinates[$i+3], $blue);
        }
    }

    public function displayMap()
    {
        header('Content-type: image/jpeg');
        imageJPEG($this->img);
        imagedestroy($this->img);
    }

    public function saveMap($file)
    {
        ob_start();
        imagepng($this->img,$file);
    }

    private function placeMarker($img,$x1,$y1,$x2,$y2,$color)
    {
        imagefilledrectangle($img,$x1,$y1,$x2,$y2,$color);
    }
}
?>