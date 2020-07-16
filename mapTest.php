<?php
include 'Map.php';
include 'DataGetter.php';
include 'Display.php';

$getter = new DataGetter();

$getter->getShelves();
$shelves = $getter->returnShelvesBlocks();

$map1 = new Map('images/VGTUB_1a.png');
$map1->fillMapByTheme($shelves,"Matematika");
$map1->saveMap("images/NewMap.png");
?>