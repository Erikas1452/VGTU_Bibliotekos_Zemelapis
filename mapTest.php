<?php
include 'Map.php';
include 'DataGetter.php';
include 'Display.php';

$shelves[0] = new Shelf(64,432, 120,453, "201 Auditorija", array("Matematika","Diskrecioji"));
$shelves[1] = new Shelf(122,432,179,453, "201 Auditorija", array("Istorija"));
$shelves_blocks[0]=new ShelvesBlock(87,1590,151,1691,"2 Aukstas",$shelves);
Map::mapShelvesBlock($shelves_blocks[0],"Istorija");
?>