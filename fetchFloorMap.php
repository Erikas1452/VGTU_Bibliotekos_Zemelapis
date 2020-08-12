<?php
include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$img = $data->getFloor($mapId)[0];

$source = "data:image/png;base64,".$img;

$response = array($source);

echo json_encode($response);
