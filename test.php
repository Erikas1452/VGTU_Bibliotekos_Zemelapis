<?php
include "php/DataGetter.php";

$names = array("1st floor",'2nd floor');
$roomIndex=0;

 echo '<div class="tabButtons">';
        $index = 0;
        foreach($names as $floor) {
            echo '<button type="button" id="'.$index.'" onclick="showContent(), ">'.$floor.'</button>';
            $index++;
        }
        echo '</div>';
?>