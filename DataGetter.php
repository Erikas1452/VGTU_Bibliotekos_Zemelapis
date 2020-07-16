<?php

include 'ShelvesBlock.php';
include 'Shelf.php';

class DataGetter
{
    private $themes;
    private $selected_val;
    private $shelves_block;

    private $shelves_blocks;

    public function __construct()
    {
        $this->shelves_blocks = array();
    }

    public function getShelvesBlocks()
    {
        $shelves[0] = new Shelf(64,453, 120,432, "201 Auditorija", array("Matematika","Diskrecioji"));
        $shelves[1] = new Shelf(122,453,179,432, "201 Auditorija", array("Istorija"));
        $this->shelves_blocks[0]=new ShelvesBlock(87,1590,151,1691,"2 Aukstas",$shelves);
        $shelves = array();
        $shelves[0] = new Shelf(64,555,120,535,"202 Auditorija",array("Mechanika","Transporto Logistika"));
        $this->shelves_blocks[1]=new ShelvesBlock(87,1742,151,1843,"2 Aukstas",$shelves);
    }

    public function printShelves()
    {
        foreach($this->shelves_block as $shelf)
        {
            echo '<br>';
            foreach($shelf as $item)
            {
                echo $item.' ';
            }
        }
    }

    public function getShelves()
    {
        //101 y-ai
        //51 x-ai
        $shelf = array(87,1590,151,1691,"Matematika","Diskrecioji");
        $this->shelves_block[0]=$shelf;
        $shelf=array(87,1742,151,1843,"Istorija");
        $this->shelves_block[1]=$shelf;
        $shelf=array(202,1590,266,1691,"Mechanika","Transporto Logistika");
        $this->shelves_block[2]=$shelf;
    }

    public function getValueFromSelection($button,$value_to_get)
    {
        if (isset($_POST[$button]))
        {
            $this->selected_val = $_POST[$value_to_get];
        }
    }

    public function getThemes ()
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