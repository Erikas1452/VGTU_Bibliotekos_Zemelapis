<?php

include 'ShelvesBlock.php';
include 'Shelf.php';

class DataGetter
{
    private $themes;
    private $selected_val;

    private $shelves_blocks;

    public function __construct()
    {
        $this->shelves_blocks = array();
    }

    public function getShelvesBlocks()
    {
        $shelves[0] = new Shelf(64,432, 120,453, "201 Auditorija", array("Matematika","Diskrecioji"));
        $shelves[1] = new Shelf(122,432,179,453, "201 Auditorija", array("Istorija"));
        $this->shelves_blocks[0]=new ShelvesBlock(87,1590,151,1691,"2 Aukstas",$shelves);
        $shelves = array();
        $shelves[0] = new Shelf(64,535,120,555,"202 Auditorija",array("Mechanika","Transporto Logistika"));
        $this->shelves_blocks[1]=new ShelvesBlock(87,1742,151,1843,"2 Aukstas",$shelves);
    }

    public function getValueFromSelection($button,$value_to_get)
    {
        if (isset($_POST[$button]))
        {
            $this->selected_val = $_POST[$value_to_get];
        }
    }

    public function getThemes()
    {
        $theme1 = array("Matematika", "001");
        $theme2 = array ("Diskrecioji", "002");
        $theme3 = array("Transporto Logistika", "003");
        $theme4 = array("Istorija", "004");
        $theme5 = array("Mechanika", "005");
        $this->themes[0] = $theme1;
        $this->themes[1] = $theme2;
        $this->themes[2] = $theme3;
        $this->themes[3] = $theme4;
        $this->themes[4] = $theme5;
    }

    public function returnThemes()
    {
        return $this->themes;
    }

    public function returnSelectedValue()
    {
        return $this->selected_val;
    }

    public function returnShelvesBlocks()
    {
        return $this->shelves_block;
    }

    public function returnBlocks()
    {
        return $this->shelves_blocks;
    }
}
?>