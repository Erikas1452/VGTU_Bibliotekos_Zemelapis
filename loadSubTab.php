<?php

include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$img = $data->getRoom($mapId);

echo'<div class="floorImage">';

//echo'<button onclick="drawAllShelves('.$mapId.')"> MARK ALL </button>'; For testing if all given coordinates for drawing are correct

echo'<canvas name="'.$mapId.'" id="roomCanvas"></canvas>';
    echo'<div class="tableContents">';

    echo'</div>';
echo'</div>';

?>
