<?php
class ShelvesBlock
{
    private $shelves;
    private $themes;
    private $x1;
    private $x2;
    private $y1;
    private $y2;
    private $themesCount;
    private $floor;

    function __construct($x1, $y1, $x2, $y2, $floor, $shelves)
    {
        $this->shelves=array();
        $this->themes=array();

        $this->floor = $floor;

        $this->themesCount = 0;

        $this->x1 = $x1;
        $this->x2 = $x2;
        $this->y1 = $y1;
        $this->y2 = $y2;

        $this->shelves = $shelves;

        foreach($this->shelves as $shelf)
        {
            $allThemes = $shelf->returnThemes();
            foreach ($allThemes as $oneTheme)
            {
                if(!in_array($oneTheme,$this->themes))
                {
                    $this->themes[$this->themesCount] = $oneTheme;
                    $this->themesCount++;
                }
            }
        }
    }

    public function returnCoordinates()
    {
        return array($this->x1,$this->y1,$this->x2,$this->y2);
    }

    public function returnShelves()
    {
        return $this->shelves;
    }

    public function returnThemes()
    {
        return $this->themes;
    }
}

?>