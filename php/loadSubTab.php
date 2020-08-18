<?php

include "DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$label = $data->getRoom($mapId)["name"];

echo'<div class="mapImage">';

echo '<p class = "label">'.$label.'</p>';
//echo'<button onclick="drawAllShelves('.$mapId.')"> MARK ALL </button>'; For testing if all given coordinates for drawing are correct

echo'<canvas name="'.$mapId.'" id="imageCanvas"></canvas>';
    echo'<div class="tableContents">';
        echo '<table>';
            echo'<tr>';
                echo'<th class="udk">UDK</th>';
                echo'<th class="theme">Tema</th>';
            echo'</tr>';
        echo '</table>';
    echo'</div>';
echo'</div>';

?>
