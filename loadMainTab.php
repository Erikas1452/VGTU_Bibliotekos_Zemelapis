<?php
include "php/Map.php";
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



echo'<div class="subTabButtons">';
    $index=0;
    if(isset($subtabs))
    {
        foreach ($rooms as $room)
        {
            if(in_array($room["id"],$subtabs))
            {
                echo '<button id="subTab-' . $index . '" onclick="loadSubTab(' . $room["id"] . ',' . $index . ');">' . $room["name"] . '</button>';
                $index++;
            }
        }
    }
    else
    {
        foreach ($rooms as $room)
        {
            echo '<button id="subTab-'.$index.'" onclick="loadSubTab('.$room["id"].','.$index.');">'.$room["name"].'</button>';
            $index++;
        }
    }
echo'</div>';

echo'<div class="floorImage">';
    echo '<canvas id="floorCanvas"></canvas>';
echo'<div class="tableContents">';
    echo '<table>';

        echo'<tr>';
        echo'<th>Vieta lentynoje</th>';
        echo'<th>Tema</th>';
        echo'</tr>';


        echo'<tr>';
        echo'<td>TEST CODE</td>';
        echo'<td>TEST THEME</td>';
        echo'</tr>';

    echo '</table>';
echo'</div>';
echo'</div>';

echo'<div id="subTabContent" class="subTabContent">';

echo'</div>';

