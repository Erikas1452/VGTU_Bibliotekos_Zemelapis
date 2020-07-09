<?php
include 'Map.php';
$fakedata = array(97,223,157,236,193,303,259,319,93,295,132,340);
$map1 = new Map('images/LT1.jpg');
$map1 ->fillMap($fakedata);
$map1 ->saveMap("images/ImNewMap.jpg");
?>