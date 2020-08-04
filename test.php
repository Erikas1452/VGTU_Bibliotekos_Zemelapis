<?php
include "php/Map.php";
include "php/DataGetter.php";

$data = new DataGetter();
$data->connect();

$floorInfo = $data->getFloor(1);
$img = $floorInfo[0];
$source = "data:image/png;base64,".$img;
?>

<img id="myMap" src="<?php echo $source ?>" width="600" height="600" alt="Failed to load image"></image>
<canvas onclick="draw()" id="roomCanvas" width="3000" height="3000"></canvas>
<script>
    function draw() {
        let canvas = document.getElementById("roomCanvas");
        let ctx = canvas.getContext('2d');
        let image = document.getElementById("myMap");
        ctx.drawImage(image,0,0,500,500);
        ctx.fillStyle = "#FF0000";
        ctx.fillRect(0, 0, 150, 75);
    }
</script>