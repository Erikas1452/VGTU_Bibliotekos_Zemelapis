<?php
include "php/DataGetter.php";

if(isset($_POST['map']))
{
    $mapId = $_POST['map'];
}

$data = new DataGetter();
$data->connect();

$img = $data->getRoom($mapId);

$source = "data:image/png;base64,".$img;

$response = array($source);

echo json_encode($response);