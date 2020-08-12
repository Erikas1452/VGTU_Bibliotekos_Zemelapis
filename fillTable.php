<?php

if (isset($_POST["contents"]))
{
    $contents = $_POST["contents"];
}
if (isset($_POST["udk"])) $udk = $_POST["udk"];

echo '<table>';
    echo'<tr>';
        echo'<th>UDK</th>';
        echo'<th>Tema</th>';
    echo'</tr>';
    foreach ($contents as $themes)
    {
        foreach ($themes as $theme) {
            if(isset($udk) && $udk == $theme["udk"]) echo '<tr class="marked">';
            else echo '<tr>';
            echo '<td>' .$theme["udk"] . '</td>';
            echo '<td>'.$theme["name"].'</td>';
            echo '</tr>';
        }
    }
echo '</table>';