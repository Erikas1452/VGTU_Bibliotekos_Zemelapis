<?php
include "php/Map.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

if($mapId == 0)
{
    $contents = array("auditorija101", "auditorija102");
    $floor = Map::withName("images/VGTUB_1a.png", "1 Aukštas");
    $floor->generateBase64Uri();
}
else if($mapId == 1)
{
    $contents = array("auditorija201", "auditorija202", "auditorija203");
    $floor = Map::withName("images/VGTUB_2a.png", "1 Aukštas");
    $floor->generateBase64Uri();
}

echo'<div class="subTabButtons">';
    $index = 0;
    foreach($contents as $content)
    {
        echo '<button id="subTab-'.$index.'" onclick="loadSubTab('.$index.')">'.$content.'</button>';
        $index++;
    }
echo'</div>';

echo'<div class="floorImage">';
$width = 600;
$height = 576;
echo'<img src="'.$floor->returnBase64().'"'.' width="'.$width.'" '. 'height="'.$height.' alt="Failed to load image">';
echo'</div>';

$index = 0;
foreach($contents as $content)
{
    echo'<div id="subTabContent-'.$index.'" class="subTabContent">';

    echo'</div>';
    $index++;
}

?>