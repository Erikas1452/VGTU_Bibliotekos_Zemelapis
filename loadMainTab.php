<?php
include "php/Map.php";
include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$floorInfo = $data->getFloor($mapId);
$img = $floorInfo[0];
$rooms = $floorInfo[1];

$source = "data:image/png;base64,".$img;
$width =600;
$height=575;

echo'<div class="subTabButtons">';
    $index=0;
    foreach ($rooms as $room)
    {
        echo '<button id="subTab-'.$index.'" onclick="loadSubTab('.$room["ID_BPT"].','.$index.')">'.$room["PAVAD_BPT"].'</button>';
        $index++;
    }
echo'</div>';

echo'<div class="floorImage">';
echo'<img id="myMap" src="'.$source.'" width="'.$width.'" height="'.$height.'" alt="Failed to load image"></image>';
echo '<canvas id="floorCanvas" width="'.$width.'" height="'.$height.'"></canvas>';
echo'</div>';

echo'<div id="subTabContent" class="subTabContent">';

echo'</div>';
