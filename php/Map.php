<?php
class Map
{
    private $img;

    private $blue;
    private $gray;
    private $white;
    private $black;

    private $map_path;
    private $name;
    private $found;

    private $originalWidth;
    private $originalLength;

    private $base64Uri;

    function __construct($image)
    {
        $this->found=false;
        $this->img = imagecreatefrompng($image);
        $this->blue = imagecolorallocate($this->img, 38, 155, 240);
        $this->gray = imagecolorallocate($this->img, 211, 211, 211);
        $this->white = imagecolorallocate($this->img, 255, 255, 255);
        $this->black = imagecolorallocate($this->img, 0, 0, 0);

        $temp = getimagesize($image);

        $this->originalWidth = $temp[0];
        $this->originalLength = $temp[1];

        imagealphablending($this->img, false);
        imagesavealpha($this->img, true);
    }

    public static function withName($image,$name)
    {
        $instance = new self($image);
        $instance->name = $name;
        return $instance;
    }

    public function fillSelectedShelf($shelves,$selected)
    {
        foreach ($shelves as $shelf)
        {
            $coordinates = $shelf->returnCoordinates();
            if($coordinates == $selected->returnCoordinates()) imagefilledrectangle($this->img, $coordinates[0], $coordinates[1], $coordinates[2], $coordinates[3], $this->blue);
            else imagefilledrectangle($this->img, $coordinates[0], $coordinates[1], $coordinates[2], $coordinates[3], $this->gray);
        }
    }

    public function fillMapByTheme($shelves, $theme)
    {
        foreach ($shelves as $shelf) {
            $coordinates = $shelf->returnCoordinates();
            $themes = $shelf->returnThemes();
            for ($i = 0; $i < count($themes); $i++) {
                if ($themes[$i] == $theme) {
                    $this->found=true;
                    imagefilledrectangle($this->img, $coordinates[0], $coordinates[1], $coordinates[2], $coordinates[3], $this->blue);
                    break;
                } else {
                    imagefilledrectangle($this->img, $coordinates[0], $coordinates[1], $coordinates[2], $coordinates[3], $this->gray);
                }
            }
        }
    }

    public function generateBase64Uri()
    {
        ob_start();
        imagepng($this->img);
        $contents = ob_get_contents();
        ob_end_clean();
        $this->base64Uri = "data:image/png;base64," . base64_encode($contents);
    }

    public function displayMap()
    {
        header('Content-type: image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    public function saveMap($file)
    {
        ob_start();
        $this->map_path = $file;
        imagepng($this->img, $file);
    }

    public function returnPath()
    {
        return $this->map_path;
    }

    public function returnMap()
    {
        return $this->img;
    }

    public function returnBase64()
    {
        return $this->base64Uri;
    }

    public function returnName()
    {
        return $this->name;
    }

    public function returnStatus()
    {
        return $this->found;
    }

    public function returnWidth()
    {
        return $this->originalWidth;
    }

    public function returnLength()
    {
        return $this->originalLength;
    }
}
?>