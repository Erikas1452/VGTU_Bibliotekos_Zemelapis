<!---->
<!--<script>-->
<!--    function draw() {-->
<!--        let canvas = document.getElementById("roomCanvas");-->
<!--        let ctx = canvas.getContext('2d');-->
<!--        let image = new Image();-->
<!--        image.src = "VGTUB_101.png";-->
<!--        alert("HIII");-->
<!--        ctx.fillStyle = "#FF0000";-->
<!--        ctx.fillRect(0, 0, 150, 75);-->
<!--    }-->
<!--</script>-->

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

$source = "data:image/png;base64,".$img;
$width =600;
$height=575;

echo'<div class="floorImage">';
echo'<img id="myMap" src="'.$source.'" width="'.$width.'" height="'.$height.'" alt="Failed to load image"></image>';
echo'<canvas onclick="draw()" id="roomCanvas" width="'.$width.'" height="'.$height.'"></canvas>';
echo'</div>';

?>