<?php
include "php/DataGetter.php";

$data = new DataGetter();
$data->connect();


$mapId = $_POST['id'];

$response = $data->getRoomTables($mapId);

echo $response;
