<?php
class DataGetter
{
    var $themes = array();

    public function getThemes ()
    {
        $array = array("Matematika","Diskrecioji","Transporto Logistika","Istorija","Mechanika");
        for($i = 0; $i < count($array); $i++)
        {
            $this->themes[$i] = $array[$i];
        }
    }

    public function returnThemes()
    {
        return $this->themes;
    }
}
?>