<?php
include "php/Map.php";
include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();
//$map =new Map($data->getMap($mapId)) ;
//$map->generateBase64Uri();

$img = $data->getMap($mapId);
$source = "data:image/png;base64,".$img;
$width =600;
$height=575;



$contents = array("auditorija101", "auditorija102");


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
echo'<input name="test" type="image" src="'.$source.'" width="'.$width.'" height="'.$height.'" alt="Failed to load image">';
echo'</div>';

$index = 0;
foreach($contents as $content)
{
    echo'<div id="subTabContent-'.$index.'" class="subTabContent">';

    echo'</div>';
    $index++;
}

?>