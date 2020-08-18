<?php
include "DataGetter.php";

$data = new DataGetter();
$data->connect();

if(isset($_POST['topic']))
{
    $themeId = $_POST['topic'];
}

$response = $data->getShelves($themeId);

echo $response;