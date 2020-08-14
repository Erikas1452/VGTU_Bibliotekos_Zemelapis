<?php

include "php/DataGetter.php";

$data = new DataGetter();
$data->connect();

$mapId = $_POST['map'];

if(isset($_POST['rooms']))
{
    $subtabs = $_POST['rooms'];
}
$floorInfo = $data->getFloor($mapId);
$rooms = $floorInfo[1];

echo'<div class="floorImage">';
    echo '<canvas name="'.$mapId.'" id="floorCanvas"></canvas>';
        echo'<div class="tableContents">';

        echo'</div>';
echo'</div>';

echo'<div id="subTabContent" class="subTabContent">';
echo'</div>';

