<?php
include "php/Map.php";
include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$img = $data->getRoom($mapId);

$width = 600;
$height = 575;

echo'<div class="floorImage">';
echo'<button onclick="drawAllShelves('.$mapId.')"> MARK ALL </button>';
echo'<canvas name="'.$mapId.'" id="roomCanvas"></canvas>';
echo'</div>';

?>
