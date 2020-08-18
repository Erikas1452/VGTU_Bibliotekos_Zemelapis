<?php
include "DataGetter.php";

$data = new DataGetter();
$data->connect();

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
    $x = $_POST['x'];
    $y = $_POST['y'];
}

$response = $data->getRoomClick($mapId, $x, $y);

echo $response;
