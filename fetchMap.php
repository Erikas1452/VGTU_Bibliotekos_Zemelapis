<?php
include "php/DataGetter.php";
include "php/Map.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$img = $data->getRoom($mapId);

$source = "data:image/png;base64,".$img;

$map = new Map($img);

$response = array($source,$img->returnWidth,$img->returnHeight);

echo json_encode($response);