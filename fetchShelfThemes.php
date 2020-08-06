<?php
include "php/DataGetter.php";

if(isset($_POST['shelfID']))
{
    $shelfId = $_POST['shelfID'];
}

$data = new DataGetter();
$data->connect();

$response = $data->getShelfThemes($shelfId);

echo $response;