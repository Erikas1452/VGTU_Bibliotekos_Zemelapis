<?php

if (isset($_POST["contents"]))
{
    $contents = $_POST["contents"];
}
echo sizeof($contents);