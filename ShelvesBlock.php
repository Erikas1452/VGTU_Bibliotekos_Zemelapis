<?php
class ShelvesBlock
{
    private $shelves;
    private $themes;
    private $x1;
    private $x2;
    private $y1;
    private $y2;
    private $themes_count;
    private $floor;

    function __construct($x1, $y1, $x2, $y2, $floor, $shelves)
    {
        $this->shelves=array();
        $this->themes=array();

        $this->floor = $floor;

        $this->themes_count = 0;

        $this->x1 = $x1;
        $this->x2 = $x2;
        $this->y1 = $y1;
        $this->y2 = $y2;

        $this->shelves = $shelves;

        foreach($this->shelves as $shelf)
        {
            $all_themes = $shelf->returnThemes();
            foreach ($all_themes as $one_theme)
            {
                if(!in_array($one_theme,$this->themes))
                {
                    $this->themes[$this->themes_count] = $one_theme;
                    $this->themes_count++;
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