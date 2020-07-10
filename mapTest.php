<?php
include 'Map.php';
include 'DataGetter.php';
include 'Display.php';

$display = new Display();
$getter = new DataGetter();
$getter->getShelves();
$shelves = $getter->returnShelves();
$map1 = new Map('images/LT1.jpg');
$map1 ->fillMapByTheme($shelves,"Matematika");
$map1 ->saveMap("images/ImNewMap.jpg");
$display->displayImage("images/ImNewMap.jpg",800,600);
?>