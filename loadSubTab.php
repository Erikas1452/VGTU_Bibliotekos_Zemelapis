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

echo'<div class="floorImage">';

//echo'<button onclick="drawAllShelves('.$mapId.')"> MARK ALL </button>'; For testing if all given coordinates for drawing are correct

echo'<canvas name="'.$mapId.'" id="roomCanvas"></canvas>';
    echo'<div class="tableContents">';
        echo '<table>';
            echo'<tr>';
                echo'<th>UDK</th>';
                echo'<th>Tema</th>';
            echo'</tr>';
                echo'<tr>';
                    echo'<td>TEST CODE</td>';
                    echo'<td>TEST THEME</td>';
                echo'</tr>';
        echo '</table>';
        echo'</div>';
echo'</div>';

?>
