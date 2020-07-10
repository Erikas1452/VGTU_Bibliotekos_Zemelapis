<?php
class Map
{
    private $img;
    private $blue;
    private $gray;
    private $white;
    private $black;

    function __construct($image)
    {
        $this->img=imagecreatefromjpeg($image);
        $this->blue = imagecolorallocate($this->img,0,0,255);
        $this->gray = imagecolorallocate($this->img,211,211,211);;
        $this->white = imagecolorallocate($this->img,255,255,255);;
        $this->black = imagecolorallocate($this->img,0,0,0);;
    }

    public function fillMap($shelves)
    {
        foreach($shelves as $shelf)
        {
            $theme_amount = count($shelf) - 4;
            for($i = 0; $i < $theme_amount; $i++)
            {
                $this->placeMarker($this->img,$shelf[0],$shelf[1],$shelf[2],$shelf[3],$this->gray);
            }
        }
    }

    public function fillMapByTheme($shelves,$theme)
    {
        foreach($shelves as $shelf)
        {
            $theme_amount = count($shelf) - 4;
            for($i = 0; $i < $theme_amount; $i++)
            {
                if($shelf[$i + 4] == $theme)
                {
                    $this->placeMarker($this->img,$shelf[0],$shelf[1],$shelf[2],$shelf[3],$this->blue);
                    break;
                }
                else
                {
                    $this->placeMarker($this->img,$shelf[0],$shelf[1],$shelf[2],$shelf[3],$this->gray);
                }
            }
        }
    }
    private function placeMarker($img,$x1,$y1,$x2,$y2,$color)
    {
        imagefilledrectangle($img,$x1,$y1,$x2,$y2,$color);
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
}
?>