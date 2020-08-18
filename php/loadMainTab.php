<?php

include "DataGetter.php";

$data = new DataGetter();
$data->connect();

$mapId = $_POST['map'];

$floorInfo = $data->getFloor($mapId);

echo'<div class="mapImage">';

echo '<p class = "label">'.$floorInfo[2].'</p>';

    echo '<canvas name="'.$mapId.'" id="imageCanvas"></canvas>';
        echo'<div class="tableContents">';

        echo'</div>';
echo'</div>';

