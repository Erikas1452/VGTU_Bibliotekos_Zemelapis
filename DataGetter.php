<?php
class DataGetter
{
    private $themes;
    private $selected_val;
    private $shelves;

    public function printShelves()
    {
        foreach($this->shelves as $shelf)
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
        $shelf = array(97,223,157,236,"Matematika","Diskrecioji");
        $this->shelves[0]=$shelf;
        $shelf=array(193,303,259,319,"Istorija");
        $this->shelves[1]=$shelf;
        $shelf=array(93,295,132,340,"Mechanika","Transporto Logistika");
        $this->shelves[2]=$shelf;
    }

    public function getValueFromSelection($button,$valuetoget)
    {
        if (isset($_POST[$button])) {
            $this->selected_val = $_POST[$valuetoget];
        }
    }

    public function getThemes ()
    {
        $array = array(" ", "Matematika", "Diskrecioji", "Transporto Logistika", "Istorija", "Mechanika");
        for ($i = 0; $i < count($array); $i++) {
            $this->themes[$i] = $array[$i];
        }
    }

    public function returnThemes()
    {
        return $this->themes;
    }

    public function returnSelectedValue()
    {
        return $this->selected_val;
    }

    public function returnShelves()
    {
        return $this->shelves;
    }
}
?>